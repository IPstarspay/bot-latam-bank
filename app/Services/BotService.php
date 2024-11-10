<?php

namespace App\Services;

use App\DTOs\BotRequestDTO;
use App\DTOs\BotResponseDTO;
use App\Repositories\ConversationFlowRepository;
use App\Clients\TelegramClient;
use Illuminate\Support\Facades\Redis;

class BotService
{
    public function __construct(
        private ConversationFlowRepository $conversationFlowRepo,
        private TelegramClient $telegramClient
    ) {}

    public function processMessage(BotRequestDTO $dto): void
    {
        $currentState = Redis::get("user:{$dto->userId}:state") ?? 'start';
        
        $flow = $this->conversationFlowRepo->getFlowByState($currentState);

        if ($flow && $this->isResponseValid($dto->text, $flow->expected_response_type)) {
            $nextState = $flow->next_state;

            if (is_null($nextState)) {
                $nextState = $dto->text;
            }

            $this->telegramClient->sendMessage(
                $dto->userId,
                new BotResponseDTO(
                    $flow->response_message,
                    $flow->options ?? []
                )
            );

            Redis::set("user:{$dto->userId}:state", $nextState);
        } else {
            $fallbackMessage = $flow->fallback_message ?? 'Desculpe, não entendi.';
            $this->telegramClient->sendMessage($dto->userId, new BotResponseDTO($fallbackMessage));
        }
    }

    private function isResponseValid(string $text, string $expectedType): bool
    {
        return match ($expectedType) {
            'text' => is_string($text),
            'number' => is_numeric($text),
            default => false,
        };
    }
}
