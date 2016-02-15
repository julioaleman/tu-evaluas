<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('section_id');
            $table->integer('blueprint_id');
            $table->text('question')->nullable();
            $table->boolean('is_description')->default(0);
            $table->boolean('is_location')->default(0);
            $table->string('type')->nullable();
            $table->integer('order_num')->nullable();
            $table->integer('default_value')->nullable();
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
        Schema::drop('questions');
    }
}
