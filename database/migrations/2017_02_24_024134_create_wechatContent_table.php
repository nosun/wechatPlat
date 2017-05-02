<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wx_contents', function($table)
        {
            $table->increments('id');
            $table->string('media_id')->default('');
            $table->tinyInteger('idx');
            $table->string('title');
            $table->string('keyword')->default('');
            $table->string('author');
            $table->string('thumb_url')->default('');
            $table->string('thumb_media_id')->default('');
            $table->string('template')->default('');;
            $table->text('digest'); // summary
            $table->longtext('content');
            $table->string('content_source_url')->default('');
            $table->string('url')->default('');
            $table->tinyInteger('show_cover_pic')->default(0);
            $table->tinyInteger('original')->default(1);
            $table->string('copyright')->default('');
            $table->string('editor')->default('');
            $table->integer('uid')->default(0);
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
        Schema::drop('wx_contents');
    }
}
