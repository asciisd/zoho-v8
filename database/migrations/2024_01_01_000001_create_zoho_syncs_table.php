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
        Schema::create('zoho_syncs', function (Blueprint $table) {
            $table->id();
            $table->string('zohoable_type');
            $table->unsignedBigInteger('zohoable_id');
            $table->string('zoho_module');
            $table->string('zoho_record_id')->nullable();
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();

            $table->index(['zohoable_type', 'zohoable_id'], 'zoho_syncs_zohoable_index');
            $table->index('zoho_record_id', 'zoho_syncs_record_id_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zoho_syncs');
    }
};
