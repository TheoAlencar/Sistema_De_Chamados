<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketAssignedNotification;
use App\Notifications\TicketStatusUpdatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;

/**
 * CONTROLLER DO ADMINISTRADOR - AdminController.php
 * Gerencia funcionalidades exclusivas do administrador
 * Acesso restrito apenas para usuários com papel 'adm'
 * Responsável por dashboards e configurações administrativas
 */
class AdminController extends Controller
{
    /**
     * DASHBOARD DO ADMINISTRADOR
     * Página inicial do painel administrativo
     * Mostra estatísticas, usuários, configurações do sistema
     */
    public function homepage()
    {
        // Estatísticas do sistema - visão geral para o administrador
        $stats = [
            'total_users' => User::count(),
            'total_tickets' => Ticket::count(),
            // Chamados abertos: exclui finalizados E arquivados para foco nos ativos
            'open_tickets' => Ticket::where('status', '!=', 'finalizado')->where('status', '!=', 'arquivado')->count(),
            'closed_tickets' => Ticket::where('status', 'finalizado')->count(),
            // Nova estatística: chamados arquivados para controle organizacional
            'archived_tickets' => Ticket::where('status', 'arquivado')->count(),
            'technicians' => User::role('tecnico')->count(),
            'clients' => User::role('cliente')->count(),
            'admins' => User::role('adm')->count(),
        ];

        // Chamados recentes
        $recentTickets = Ticket::with(['user', 'technician'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('adm.homepage', compact('stats', 'recentTickets'));
    }

    /**
     * LISTAR TODOS OS USUÁRIOS
     * Mostra lista completa de usuários com filtros e paginação
     */
    public function users(Request $request)
    {
        $query = User::with('roles');

        // Filtro por papel
        if ($request->has('role') && $request->role) {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Busca por nome ou email
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(15);
        $roles = Role::all();

        return view('adm.users', compact('users', 'roles'));
    }

    /**
     * CRIAR NOVO USUÁRIO
     * Formulário para criação de usuário
     */
    public function createUser()
    {
        $roles = Role::all();
        return view('adm.create-user', compact('roles'));
    }

    /**
     * SALVAR NOVO USUÁRIO
     * Processa criação de usuário com validação
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|size:14|unique:users',
            'email' => 'nullable|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'cpf' => $request->cpf,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('adm.users')->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * EDITAR USUÁRIO
     * Formulário para edição de usuário existente
     */
    public function editUser($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        return view('adm.edit-user', compact('user', 'roles'));
    }

    /**
     * ATUALIZAR USUÁRIO
     * Processa atualização de dados do usuário
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|size:14|unique:users,cpf,' . $user->id,
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'role' => 'required|string|exists:roles,name',
        ]);

        $user->update([
            'name' => $request->name,
            'cpf' => $request->cpf,
            'email' => $request->email,
        ]);

        // Atualizar papel se mudou
        if ($request->role !== $user->roles->first()->name) {
            $user->syncRoles([$request->role]);
        }

        return redirect()->route('adm.users')->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * DELETAR USUÁRIO
     * Remove usuário do sistema
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Não permitir deletar o próprio usuário
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Você não pode deletar seu próprio usuário!');
        }

        $user->delete();

        return redirect()->route('adm.users')->with('success', 'Usuário deletado com sucesso!');
    }

    /**
     * LISTAR TODOS OS CHAMADOS
     * Mostra lista completa de chamados com filtros
     */
    /**
     * LISTAR TODOS OS CHAMADOS
     * Mostra lista completa de chamados com filtros
     * Por padrão, oculta chamados arquivados para manter a lista limpa
     * Permite incluir arquivados via parâmetro 'include_archived'
     */
    public function tickets(Request $request)
    {
        $query = Ticket::with(['user', 'technician']);

        // Por padrão, não mostrar arquivados para manter foco nos ativos
        if (!$request->has('include_archived') || !$request->include_archived) {
            $query->where('status', '!=', 'arquivado');
        }

        // Filtros aplicáveis a todos os chamados (incluindo arquivados se solicitado)
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('priority') && $request->priority) {
            $query->where('priority', $request->priority);
        }

        if ($request->has('technician_id') && $request->technician_id) {
            $query->where('technician_id', $request->technician_id);
        }

        // Busca por título ou descrição
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(15);
        $technicians = User::role('tecnico')->get();

        return view('adm.tickets', compact('tickets', 'technicians'));
    }

    /**
     * VISUALIZAR DETALHES DE UM CHAMADO
     * Mostra informações completas do chamado + chat
     */
    public function showTicket($id)
    {
        $ticket = Ticket::with(['user', 'technician'])->findOrFail($id);
        $messages = Message::with('user')->where('ticket_id', $id)->orderBy('created_at', 'asc')->get();

        return view('adm.ticket-detail', compact('ticket', 'messages'));
    }

    /**
     * ATRIBUIR TÉCNICO A UM CHAMADO
     * Permite ao admin atribuir qualquer técnico a qualquer chamado
     */
    public function assignTechnician(Request $request, $id)
    {
        $request->validate([
            'technician_id' => 'required|exists:users,id',
        ]);

        $ticket = Ticket::findOrFail($id);
        $technician = User::findOrFail($request->technician_id);

        // Verificar se o usuário é realmente um técnico
        if (!$technician->hasRole('tecnico')) {
            return redirect()->back()->with('error', 'Usuário selecionado não é um técnico!');
        }

        $ticket->update([
            'technician_id' => $request->technician_id,
            'status' => 'em_atendimento'
        ]);

        // Enviar notificação para técnico e cliente
        $technician->notify(new TicketAssignedNotification($ticket));
        $ticket->user->notify(new TicketAssignedNotification($ticket));

        return redirect()->back()->with('success', 'Técnico atribuído com sucesso!');
    }

    /**
     * ALTERAR STATUS DO CHAMADO
     * Permite ao admin alterar o status de qualquer chamado
     * Status disponíveis: aberto, em_atendimento, finalizado, arquivado
     * O status arquivado é usado para organização e não pode ser revertido facilmente
     */
    public function updateTicketStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:aberto,em_atendimento,finalizado,arquivado',
        ]);

        $ticket = Ticket::findOrFail($id);
        $oldStatus = $ticket->status;
        $ticket->update(['status' => $request->status]);

        // Enviar notificação para cliente e técnico se atribuído
        if ($ticket->technician) {
            $ticket->technician->notify(new TicketStatusUpdatedNotification($ticket, $oldStatus, $request->status));
        }
        $ticket->user->notify(new TicketStatusUpdatedNotification($ticket, $oldStatus, $request->status));

        return redirect()->back()->with('success', 'Status do chamado atualizado com sucesso!');
    }

    /**
     * ARQUIVAR CHAMADO
     * Permite ao admin arquivar chamados finalizados
     * Funcionalidade para organização: chamados arquivados são preservados
     * mas ficam ocultos das listagens principais
     * Apenas chamados com status 'finalizado' podem ser arquivados
     */
    public function archiveTicket($id)
    {
        $ticket = Ticket::findOrFail($id);

        // Validação: apenas chamados finalizados podem ser arquivados
        // Isso garante integridade dos dados e fluxo de trabalho
        if ($ticket->status !== 'finalizado') {
            return redirect()->back()->with('error', 'Apenas chamados finalizados podem ser arquivados!');
        }

        // Muda status para arquivado
        $ticket->update(['status' => 'arquivado']);

        return redirect()->back()->with('success', 'Chamado arquivado com sucesso!');
    }

    /**
     * DELETAR CHAMADO
     * Remove chamado do sistema (apenas para admin)
     */
    public function deleteTicket($id)
    {
        $ticket = Ticket::findOrFail($id);

        // Deletar também as mensagens relacionadas
        Message::where('ticket_id', $id)->delete();

        $ticket->delete();

        return redirect()->route('adm.tickets')->with('success', 'Chamado deletado com sucesso!');
    }

    /**
     * RELATÓRIOS DO SISTEMA
     * Página com estatísticas detalhadas e gráficos
     */
    public function reports()
    {
        // Estatísticas detalhadas para relatórios
        $stats = [
            'total_users' => User::count(),
            'total_tickets' => Ticket::count(),
            'open_tickets' => Ticket::where('status', '!=', 'finalizado')->where('status', '!=', 'arquivado')->count(),
            'closed_tickets' => Ticket::where('status', 'finalizado')->count(),
            'archived_tickets' => Ticket::where('status', 'arquivado')->count(),
            'technicians' => User::role('tecnico')->count(),
            'clients' => User::role('cliente')->count(),
            'admins' => User::role('adm')->count(),
        ];

        // Chamados por mês (últimos 12 meses)
        $monthlyTickets = Ticket::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Chamados por prioridade
        $ticketsByPriority = Ticket::selectRaw('priority, COUNT(*) as count')
            ->groupBy('priority')
            ->get()
            ->pluck('count', 'priority');

        // Tempo médio de resolução (para chamados finalizados)
        $avgResolutionTime = Ticket::where('status', 'finalizado')
            ->whereNotNull('updated_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_hours')
            ->first();

        return view('adm.reports', compact('stats', 'monthlyTickets', 'ticketsByPriority', 'avgResolutionTime'));
    }

    /**
     * CONFIGURAÇÕES DO SISTEMA
     * Página para configurações administrativas
     */
    public function settings()
    {
        // Por enquanto, apenas uma página básica
        // Futuramente pode incluir configurações como:
        // - Configurações de email
        // - Limites de sistema
        // - Configurações de backup
        // - etc.

        return view('adm.settings');
    }
}
