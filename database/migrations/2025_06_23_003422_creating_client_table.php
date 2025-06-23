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
        Schema::create("clients", function (Blueprint $table) {
            $table->id();
            $table->string("nome_completo");
            $table->string("email");
            $table->string("telefone");
            $table->string("cpf")->unique();
            $table->string("rg");
            $table->string("endereco")->nullable();
            $table->string("complemento")->nullable();
            $table->string("cidade")->nullable();
            $table->string("estado")->nullable();
            $table->string("cep")->nullable();
            $table->string("observacoes")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("clients");
    }
};
