<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('conversation_flows', function (Blueprint $table) {
            $table->id();
            $table->string('current_state')->index();
            $table->string('expected_response_type');
            $table->text('response_message');
            $table->string('next_state')->nullable();
            $table->text('fallback_message')->nullable();
            $table->json('options')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversation_flows');
    }
};
