<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = ['user_id', 'category_id', 'title', 'priority', 'status', 'description', 'assigned_to'];
    protected $casts = [
        'user_id' => 'integer',
        'category_id' => 'integer',
        'status' => 'string',
        'priority' => 'string',
    ];
    public function statusClass(): string
    {
        return match ($this->status) {
            'aberto' => 'px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800',
            'em_andamento' => 'px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800',
            'fechado' => 'px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800',
            default => 'px-2 py-1 text-xs font-semibold rounded-full bg-gray-200 text-gray-600',
        };
    }

    public function priorityClass(): string
    {
        return match ($this->prioridade) {
            'alta' => 'text-red-500',
            'media' => 'text-yellow-500',
            'baixa' => 'text-green-500',
            default => 'text-gray-500',
        };
    }
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Relacionamentos
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
