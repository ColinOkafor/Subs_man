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
        Schema::create('_subscription', function (Blueprint $table) {
            $table->id();
            $table->foreignId()
                  ->constrained()
                  ->onDelete('cascade');
            $table->string('name');
            $table->double('amount');
            $table->string('status');
            $table->string('billing_cycle');
            $table->date('start_date');
            $table->date('next_billing_cycle');
            $table->longText('short_note');
            $table->string('category');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_subscription');
    }
};
