<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wx_images', function($table)
        {
            $table->increments('id');
            $table->string('media_id')->default('');
            $table->string('name');
            $table->string('path');
            $table->string('url');
            $table->timestamps();
            $table->index('media_id','media_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wx_images');
    }
}
