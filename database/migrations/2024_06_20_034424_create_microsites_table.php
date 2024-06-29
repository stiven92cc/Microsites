<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('microsites', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('slug');
            $table->string('logo')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')
                ->references('id')
                ->on('categories');
            $table->enum('type', ['invoice', 'subscription', 'donation']);
            $table->string('currency');
            $table->integer('payment_expiration');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('microsites');
    }
};
