<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationFlow extends Model
{
    use HasFactory;

    protected $fillable = [
        'current_state',
        'expected_response_type',
        'response_message',
        'next_state',
        'fallback_message',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];
}
