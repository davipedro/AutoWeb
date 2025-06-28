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

        Schema::table('sellers', function (Blueprint $table) {
            $table->double('salario', 10, 2)->after('comissao');
            $table->date('data_admissao')->nullable()->after('salario');
            $table->string('cpf')->unique()->after('data_admissao');
            $table->string('rg')->after('cpf');
            $table->string('endereco')->nullable()->after('rg');
            $table->string('complemento')->nullable()->after('endereco');
            $table->string('cidade')->nullable()->after('complemento');
            $table->string('estado')->nullable()->after('cidade');
            $table->string('cep')->nullable()->after('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn(['salario', 'data_admissao', 'cpf', 'rg', 'endereco', 'complemento', 'cidade', 'estado', 'cep']);
        });
    }
};
