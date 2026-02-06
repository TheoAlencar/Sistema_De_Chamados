<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticket;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Novo Chamado Criado: ' . $this->ticket->title)
            ->greeting('Olá!')
            ->line('Um novo chamado foi criado no sistema.')
            ->line('**Título:** ' . $this->ticket->title)
            ->line('**Descrição:** ' . $this->ticket->description)
            ->line('**Prioridade:** ' . ucfirst($this->ticket->priority))
            ->line('**Cliente:** ' . $this->ticket->user->name)
            ->action('Ver Chamado', url('/admin/tickets/' . $this->ticket->id))
            ->salutation('Atenciosamente, Sistema de Chamados');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
