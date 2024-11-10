<?php

namespace App\DTOs;

class BotResponseDTO
{
    public function __construct(
        public string $text,
        public array $options = []
    ) {}
}
