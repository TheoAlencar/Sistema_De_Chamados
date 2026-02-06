<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketAssignedNotification extends Notification implements ShouldQueue
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
        $message = (new MailMessage)
            ->subject('Chamado Atribuído: ' . $this->ticket->title)
            ->greeting('Olá!')
            ->line('Um técnico foi atribuído ao chamado.')
            ->line('**Título:** ' . $this->ticket->title)
            ->line('**Técnico:** ' . $this->ticket->technician->name)
            ->action('Ver Chamado', url('/cliente/ticket/' . $this->ticket->id)) // Ajustar URL baseado no role
            ->salutation('Atenciosamente, Sistema de Chamados');

        // Personalizar URL baseado no role do notifiable
        if ($notifiable->hasRole('tecnico')) {
            $message->action('Ver Chamado', url('/tecnico/ticket/' . $this->ticket->id));
        } elseif ($notifiable->hasRole('cliente')) {
            $message->action('Ver Chamado', url('/cliente/ticket/' . $this->ticket->id));
        }

        return $message;
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
