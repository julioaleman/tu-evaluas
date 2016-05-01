<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBlueprintFieldAddSendHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blueprints', function (Blueprint $table) {
            $table->string("header")->nullable();
            $table->string("body")->nullable();
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blueprints', function (Blueprint $table) {
            //
        });
    }
}
