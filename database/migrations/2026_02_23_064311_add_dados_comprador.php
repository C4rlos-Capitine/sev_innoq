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
        Schema::table('pedidos', function (Blueprint $table) {
            $table->enum('tipo_comprador', ['individual', 'empresa'])->nullable();
            $table->string('nome_completo_comprador')->nullable();
            $table->string('email_comprador')->nullable();
            $table->string('telefone_comprador')->nullable();
            $table->string('nuit_comprador')->nullable();
            $table->string('codigo_pedido')->uniqidue()->nullable();
            $table->enum('tipo_doc',['Digital', 'Físico'])->default('Digital');
            $table->enum('estado', ['pendente', 'processando', 'concluido', 'cancelado'])->default('pendente')->change();
            $table->bigInteger('id_provincia')->unsigned()->nullable();
            $table->foreign('id_provincia')->references('id_provincia')->on('provincias')->onDelete('set null');
            $table->string('endereco_comprador')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            dropColumn('tipo_comprador');
            dropColumn('nome_completo_comprador');
            dropColumn('email_comprador');
            dropColumn('telefone_comprador');
            dropColumn('nuit_comprador');
            dropColumn('codigo_pedido');
            dropColumn('tipo_doc');
            dropColumn('estado');
            dropColumn('id_provincia');
            dropColumn('endereco_comprador');

        });
    }
};
