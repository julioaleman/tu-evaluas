<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMailgunCounterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailgun_emails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("emails")->default(0);
            $table->integer("blueprint");
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
        Schema::drop('mailgun_emails');
    }
}
