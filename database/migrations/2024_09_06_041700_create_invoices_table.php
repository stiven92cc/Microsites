<?php

use App\Constants\InvoicesStatus;
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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('reference');
            $table->string('description');
            $table->string('number');
            $table->enum('status', InvoicesStatus::getInvoicesStatus())->default(InvoicesStatus::PENDING->value);
            $table->string('email');
            $table->decimal('amount', 10, 2);
            $table->string('currency');
            $table->string('phone_number');
            $table->string('document_type');
            $table->string('document');
            $table->foreignId('microsite_id')->constrained()->onDelete('cascade');
            $table->timestamp('expired_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
