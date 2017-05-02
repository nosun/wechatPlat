<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldForWechatContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wx_contents', function(Blueprint $table){
            $table->text('note')->default('');
            $table->tinyInteger('supportSwitch')->default(1);
            $table->index('media_id','media_id');
            $table->index('thumb_media_id','thumb_media_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wx_contents', function(Blueprint $table){
            $table->dropColumn('note');
            $table->dropColumn('supportSwitch');
        });
    }
}
