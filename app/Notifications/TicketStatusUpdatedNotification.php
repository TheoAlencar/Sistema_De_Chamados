<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketStatusUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticket;
    protected $oldStatus;
    protected $newStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ticket $ticket, $oldStatus, $newStatus)
    {
        $this->ticket = $ticket;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
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
            ->subject('Status do Chamado Atualizado: ' . $this->ticket->title)
            ->greeting('Olá!')
            ->line('O status do chamado foi atualizado.')
            ->line('**Chamado:** ' . $this->ticket->title)
            ->line('**Status Anterior:** ' . ucfirst($this->oldStatus))
            ->line('**Novo Status:** ' . ucfirst($this->newStatus))
            ->action('Ver Chamado', url('/cliente/ticket/' . $this->ticket->id))
            ->salutation('Atenciosamente, Sistema de Chamados');

        // Personalizar URL
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
