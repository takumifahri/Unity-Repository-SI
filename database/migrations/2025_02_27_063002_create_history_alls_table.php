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
        Schema::create('history_alls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('items_id');
            $table->unsignedBigInteger('user_id');
            $table->string('reason')->nullable();
            $table->json('new_value')->nullable();
            $table->json('old_value')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_alls');
    }
};
