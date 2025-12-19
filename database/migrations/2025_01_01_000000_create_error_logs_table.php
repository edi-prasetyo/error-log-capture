<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('error_logs', function (Blueprint $table) {
            $table->id();
            $table->string('exception');
            $table->text('message');
            $table->string('file');
            $table->unsignedInteger('line');
            $table->longText('trace')->nullable();
            $table->string('url')->nullable();
            $table->string('method', 10)->nullable();
            $table->string('ip', 45)->nullable();
            $table->unsignedInteger('count')->default(1);
            $table->tinyInteger('solved')->default(0);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('hash', 64)->index();
            $table->timestamp('occurred_at')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('error_logs');
    }
};
