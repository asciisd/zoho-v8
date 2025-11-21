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
        Schema::create('zoho_oauth_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('user_identifier')->default('default')->index();
            $table->text('access_token');
            $table->text('refresh_token')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->string('token_type')->default('Bearer');
            $table->text('grant_token')->nullable();
            $table->string('data_center')->default('US');
            $table->string('environment')->default('production');
            $table->timestamps();

            $table->unique(['user_identifier', 'data_center', 'environment']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zoho_oauth_tokens');
    }
};
