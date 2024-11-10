<?php

namespace App\DTOs;

class BotRequestDTO
{
    public function __construct(
        public int $userId,
        public string $text
    ) {}
}
