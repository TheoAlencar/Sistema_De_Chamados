<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\MessageSentNotification;
use App\Notifications\TicketCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ClienteController extends Controller
{
    /**
     * Exibe o dashboard do cliente com seus chamados
     * Mostra estatísticas e lista de chamados criados pelo usuário
     */
    public function homepage(Request $request)
    {
        $user = auth()->user();

        // Chamados do cliente
        $ticketsQuery = Ticket::where('user_id', $user->id);

        // Aplicar filtro se fornecido
        $filter = $request->query('filter');
        if ($filter === 'chat_tecnico') {
            $ticketsQuery->whereNotNull('technician_id')
                        ->where('status', '!=', 'finalizado');
        }
        // Para 'meus_chamados', não aplica filtro adicional, mostra todos

        $tickets = $ticketsQuery->get();
        return view('cliente.homepage', compact('tickets', 'filter'));
    }

    /**
     * Exibe o formulário para criar um novo chamado
     */
    public function createTicket()
    {
        return view('create-ticket');
    }

    /**
     * Processa a criação de um novo chamado
     * Valida os dados e salva no banco
     */
    public function storeTicket(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'priority' => 'required|in:baixa,media,alta',
        ]);

        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'user_id' => auth()->id(),
            'status' => 'aberto',
        ]);

        // Enviar notificação para admins e técnicos
        $adminsAndTechnicians = User::role(['adm', 'tecnico'])->get();
        Notification::send($adminsAndTechnicians, new TicketCreatedNotification($ticket));

        return redirect()->route('cliente.homepage')->with('success', 'Chamado criado com sucesso!');
    }

    /**
     * Processa o envio de mensagens no chat do chamado
     * Verifica se o chamado pertence ao usuário antes de permitir
     */
    public function storeMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', // Até 2MB, tipos permitidos
        ]);

        $ticket = Ticket::findOrFail($id);

        // Verificar se o ticket pertence ao usuário logado
        if ($ticket->user_id !== auth()->id()) {
            abort(403, 'Acesso negado');
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

        // Enviar notificação para o técnico se atribuído
        if ($ticket->technician) {
            $ticket->technician->notify(new MessageSentNotification($message, $ticket));
        }

        return redirect()->back()->with('success', 'Mensagem enviada com sucesso!');
    }

    /**
     * Exibe os detalhes de um chamado específico
     * Inclui informações do chamado e histórico de mensagens
     */
    public function showTicket($id)
    {
        $ticket = Ticket::with(['user', 'technician'])->findOrFail($id);

        // Verificar se o ticket pertence ao usuário logado
        if ($ticket->user_id !== auth()->id()) {
            abort(403, 'Acesso negado');
        }

        $messages = Message::with('user')->where('ticket_id', $id)->orderBy('created_at', 'asc')->get();

        return view('Ticket', compact('ticket', 'messages'));
    }
}
