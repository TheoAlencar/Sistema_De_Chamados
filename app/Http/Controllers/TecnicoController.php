<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Ticket;
use App\Notifications\MessageSentNotification;
use App\Notifications\TicketAssignedNotification;
use App\Notifications\TicketStatusUpdatedNotification;
use Illuminate\Http\Request;

class TecnicoController extends Controller
{
    /**
     * DASHBOARD DO TÉCNICO
     * Mostra chamados atribuídos ao técnico e chamados disponíveis para pegar
     */
    public function homepage(Request $request)
    {
        $user = auth()->user();

        // Chamados atribuídos ao técnico
        $assignedTicketsQuery = Ticket::where('technician_id', $user->id);

        // Aplicar filtro se fornecido
        $filter = $request->query('filter');
        if ($filter === 'em_atendimento') {
            $assignedTicketsQuery->where('status', 'em_atendimento');
        } elseif ($filter === 'finalizados') {
            $assignedTicketsQuery->where('status', 'finalizado');
        }
        // Para 'meus_chamados', não aplica filtro adicional, mostra todos atribuídos

        $assignedTickets = $assignedTicketsQuery->get();

        // Chamados disponíveis (sem técnico atribuído)
        $availableTickets = Ticket::whereNull('technician_id')
            ->where('status', '!=', 'finalizado')
            ->get();

        return view('tecnico.homepage', compact('assignedTickets', 'availableTickets', 'filter'));
    }

    /**
     * VISUALIZAR DETALHES DE UM CHAMADO
     * Mostra informações completas do chamado + chat com cliente
     * Só permite acesso a chamados atribuídos ao técnico
     */
    public function showTicket($id)
    {
        $ticket = Ticket::with(['user', 'technician'])->findOrFail($id);

        // Verificar se o ticket está atribuído ao técnico logado
        if ($ticket->technician_id !== auth()->id()) {
            abort(403, 'Acesso negado. Este chamado não está atribuído a você.');
        }

        $messages = Message::with('user')->where('ticket_id', $id)->orderBy('created_at', 'asc')->get();

        return view('tecnico.ticket', compact('ticket', 'messages'));
    }

    /**
     * ATRIBUIR CHAMADO AO TÉCNICO
     * Permite que um técnico "pegue" um chamado disponível
     * Muda status automaticamente para "em_atendimento"
     */
    public function assignTicket($id)
    {
        $ticket = Ticket::findOrFail($id);

        // Verificar se o ticket já tem técnico atribuído
        if ($ticket->technician_id) {
            return redirect()->back()->with('error', 'Este chamado já está atribuído a outro técnico.');
        }

        $ticket->update([
            'technician_id' => auth()->id(),
            'status' => 'em_atendimento'
        ]);

        // Enviar notificação para o cliente
        $ticket->user->notify(new TicketAssignedNotification($ticket));

        return redirect()->route('tecnico.homepage')->with('success', 'Chamado atribuído com sucesso!');
    }

    /**
     * ATUALIZAR STATUS DO CHAMADO
     * Permite ao técnico alterar o status do chamado
     * Valida se o técnico tem permissão para o chamado
     * Status possíveis: em_atendimento, resolvido, fechado
     */
    public function updateTicketStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:aberto,em_atendimento,finalizado',
        ]);

        $ticket = Ticket::findOrFail($id);

        // Verificar se o ticket está atribuído ao técnico logado
        if ($ticket->technician_id !== auth()->id()) {
            abort(403, 'Acesso negado.');
        }

        $oldStatus = $ticket->status;
        $ticket->update(['status' => $request->status]);

        // Enviar notificação para o cliente
        $ticket->user->notify(new TicketStatusUpdatedNotification($ticket, $oldStatus, $request->status));

        return redirect()->back()->with('success', 'Status do chamado atualizado com sucesso!');
    }

    /**
     * ENVIAR MENSAGEM NO CHAT
     * Permite ao técnico enviar mensagens no chat do chamado
     * Valida se o técnico tem permissão para o chamado
     * Salva a mensagem e redireciona de volta ao chamado
     */
    public function storeMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $ticket = Ticket::findOrFail($id);

        // Verificar se o ticket está atribuído ao técnico logado
        if ($ticket->technician_id !== auth()->id()) {
            abort(403, 'Acesso negado.');
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        $message = Message::create([
            'message' => $request->message,
            'ticket_id' => $id,
            'user_id' => auth()->id(),
            'attachment' => $attachmentPath,
        ]);

        // Enviar notificação para o cliente
        $ticket->user->notify(new MessageSentNotification($message, $ticket));

        return redirect()->back()->with('success', 'Mensagem enviada com sucesso!');
    }
}
