<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trabajo_id')->constrained('trabajos')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('nombre_original', 100);
            $table->string('nombre_archivo', 100);
            $table->string('descripcion', 100);
            $table->string('peso', 100);
            $table->string('extension', 100);
            $table->foreignId('documento_historial_id')->nullable()->constrained('documentos')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('documentos');
    }
}
