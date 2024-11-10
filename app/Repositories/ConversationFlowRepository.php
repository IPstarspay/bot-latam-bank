<?php

namespace App\Repositories;

use App\Models\ConversationFlow;

class ConversationFlowRepository
{
    public function getFlowByState(string $state): ?ConversationFlow
    {
        return ConversationFlow::where('current_state', $state)->first();
    }
}
