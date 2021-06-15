<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabajoMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajo_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trabajo_id')->constrained('trabajos')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('material_id')->constrained('materials')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('negocio_material_id')->constrained('negocio_materials')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('cantidad');
            $table->bigInteger('precio');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabajo_materials');
    }
}
