<?php

use App\Constants\SubscriptionPeriods;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('description');
            $table->decimal('amount', 10);
            $table->enum('subscription_period', SubscriptionPeriods::getAllSubscriptionPeriods());
            $table->integer('expiration_time');
            $table->unsignedBigInteger('microsite_id');
            $table->timestamps();
            $table->foreign('microsite_id')
                ->references('id')
                ->on('microsites')
                ->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('suscription_plans');
    }
};
