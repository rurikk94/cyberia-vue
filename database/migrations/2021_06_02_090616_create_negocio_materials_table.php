<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNegocioMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('negocio_materials', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('precio');
            $table->softDeletes();
            $table->timestamps();

            $table->foreignId('electricista_id')->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('material_id')->constrained('materials')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('negocio_id')->constrained('negocios')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('negocio_materials');
    }
}
