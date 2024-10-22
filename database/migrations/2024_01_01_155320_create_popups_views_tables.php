<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dashed__ternair_views', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ternair_id')
                ->constrained('dashed__ternair')
                ->cascadeOnDelete();
            $table->string('ip_address');
            $table->text('user_agent');
            $table->string('session_id');
            $table->integer('seen_count')
                ->default(0);
            $table->dateTime('first_seen_at');
            $table->dateTime('last_seen_at');
            $table->dateTime('closed_at')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dashed__ternair_views', function (Blueprint $table) {
            //
        });
    }
};
