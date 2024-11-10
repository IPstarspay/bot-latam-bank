<?php

namespace App\Clients;

use GuzzleHttp\Client;
use App\DTOs\BotResponseDTO;

class TelegramClient
{
    protected Client $httpClient;
    protected string $token;

    public function __construct()
    {
        $this->httpClient = new Client();
        $this->token = env('TELEGRAM_BOT_TOKEN');
    }

    public function sendMessage(int $chatId, BotResponseDTO $response): void
    {
        $url = "https://api.telegram.org/bot{$this->token}/sendMessage";

        $this->httpClient->post($url, [
            'json' => [
                'chat_id' => $chatId,
                'text' => $response->text,
                'reply_markup' => [
                    'inline_keyboard' => $response->options,
                ],
            ],
        ]);
    }
}
