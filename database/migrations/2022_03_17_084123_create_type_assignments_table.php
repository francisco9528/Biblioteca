<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user')->unsigned();;
            $table->bigInteger('id_book')->unsigned();;
            $table->dateTime('date_output');
            $table->dateTime('date_input')->nullable();
            $table->integer('flag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments');
    }
}
