<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCyclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cycles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->boolean('completed')->default(0);
            $table->date('date');
            $table->timestamps();
        });

        Schema::table('issues', function(Blueprint $table){
            $table->unsignedInteger('cycle_id')->nullable();
            $table->foreign('cycle_id')->references('id')->on('cycles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cycles');
    }
}
