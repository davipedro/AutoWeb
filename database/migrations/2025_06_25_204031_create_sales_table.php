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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->date('data_venda');
            $table->decimal('valor_total', 10, 2);
            $table->decimal('comissao', 8, 2);
            $table->enum('metodo_pagamento', ['Cartão de Crédito', 'PIX', 'Dinheiro', 'Transferência Bancária']);

            // Chaves estrangeiras
            $table->foreignId('vendedor_id')->constrained('sellers');
            $table->foreignId('cliente_id')->constrained('clients');
            $table->foreignId('veiculo_id')->constrained('vehicles');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
