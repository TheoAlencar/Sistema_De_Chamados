<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * MODELO TICKET - CHAMADO DO SISTEMA
 * Representa um chamado/ticket no sistema de suporte
 * Contém informações sobre o problema, status e responsável
 * Relacionamentos: pertence a um usuário (cliente) e pode ter um técnico
 */
class Ticket extends Model
{
    /**
     * CAMPOS PREENCHÍVEIS
     * Define os campos que podem ser atribuídos em massa
     * Inclui dados do chamado e relacionamentos
     */
    protected $fillable = [
        'title',        // Título do chamado
        'description',  // Descrição detalhada do problema
        'status',       // Status: aberto, em_atendimento, finalizado
        'priority',     // Prioridade: baixa, media, alta
        'user_id',      // ID do cliente que criou o chamado
        'technician_id', // ID do técnico responsável (pode ser null)
    ];

    /**
     * RELACIONAMENTO: USUÁRIO (CLIENTE)
     * Um chamado pertence a um usuário que o criou
     * Retorna o cliente proprietário do chamado
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * RELACIONAMENTO: TÉCNICO RESPONSÁVEL
     * Um chamado pode ter um técnico atribuído
     * Retorna o técnico responsável pelo atendimento
     */
    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}
