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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_number');
            $table->enum('type',['raw_material','products'])->default('products');
            $table->string('party_name');
            $table->date('invoice_date');
            $table->decimal('subtotal')->default(0);
            $table->decimal('tax')->default(0);
            $table->decimal('discount')->default(0);
            $table->decimal('total')->default(0);
            $table->enum('status',['paid','unpaid','pending']);
            $table->text('description')->nullable();

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
