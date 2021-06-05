<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('electricista_id')->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('codigo_trabajo', 100)->comment('codigo secreto para ingresar como cliente');
            $table->string('nombre_trabajo', 100);
            $table->foreignId('cliente_id')->constrained('clientes')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('ubicacion', 100);
            $table->text('descripcion');
            $table->unsignedTinyInteger('cotizacion_estado');
            $table->unsignedTinyInteger('avance_estado');
            $table->json('potencia');
            $table->unsignedTinyInteger('tipo_trabajo');
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabajos');
    }
}
