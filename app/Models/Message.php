<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * MODELO MESSAGE - MENSAGENS DO CHAT
 * Representa uma mensagem no sistema de chat dos chamados
 * Permite comunicação entre cliente e técnico
 * Cada mensagem pertence a um chamado e um usuário
 */
class Message extends Model
{
    /**
     * CAMPOS PREENCHÍVEIS
     * Define os campos que podem ser atribuídos em massa
     * Contém o conteúdo da mensagem e relacionamentos
     */
    protected $fillable = [
        'message',    // Conteúdo da mensagem
        'ticket_id',  // ID do chamado ao qual a mensagem pertence
        'user_id',    // ID do usuário que enviou a mensagem
        'attachment', // Caminho do arquivo anexado (opcional)
    ];

    /**
     * RELACIONAMENTO: CHAMADO
     * Uma mensagem pertence a um chamado específico
     * Permite navegar do chat para o chamado
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * RELACIONAMENTO: USUÁRIO
     * Uma mensagem é enviada por um usuário (cliente ou técnico)
     * Permite identificar quem enviou cada mensagem
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
