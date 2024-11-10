<?php

namespace App\Http\Controllers;

use App\DTOs\BotRequestDTO;
use App\Services\BotService;
use Illuminate\Http\Request;

class TelegramBotController extends Controller
{
    public function __construct(private BotService $service)
    {
    }

    public function handleWebhook(Request $request)
    {
        $data = $request->all();

        $dto = new BotRequestDTO(
            userId: $data['message']['from']['id'] ?? $data['callback_query']['from']['id'],
            text: $data['message']['text'] ?? $data['callback_query']['data']
        );

        $this->service->processMessage($dto);

        return response()->json(['status' => 'success']);
    }
}
