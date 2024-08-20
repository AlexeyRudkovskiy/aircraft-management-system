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
        Schema::create('service_statuses', function (Blueprint $table) {
            $table->id();

            $table->enum('status', array_column(\App\Enums\ServiceRequest\Status::cases(), 'value'));
            $table->foreignIdFor(\App\Models\ServiceRequest::class, 'service_request_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\User::class, 'user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_statuses');
    }
};
