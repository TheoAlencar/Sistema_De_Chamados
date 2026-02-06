<?php

namespace App\Notifications;

use App\Models\Message;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class MessageSentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;
    protected $ticket;

    /**
     * Create a new notification instance.
     */
    public function __construct(Message $message, Ticket $ticket)
    {
        $this->message = $message;
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
            ->subject('Nova Mensagem no Chamado: ' . $this->ticket->title)
            ->greeting('Olá!')
            ->line('Uma nova mensagem foi enviada no chamado.')
            ->line('**Chamado:** ' . $this->ticket->title)
            ->line('**De:** ' . $this->message->user->name)
            ->line('**Mensagem:** ' . Str::limit($this->message->message, 100))
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
