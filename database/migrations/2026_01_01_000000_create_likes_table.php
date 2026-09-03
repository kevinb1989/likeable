<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('likes')) {
            return;
        }

        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->morphs('likable');
            $table->timestamps();

            $table->unique(['user_id', 'likable_id', 'likable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
