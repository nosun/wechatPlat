<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatSite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wx_site',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('type')->default(0); // 1 订阅号, 2 服务号
            $table->string('logo')->default('');    // logo url
            $table->string('qrcode')->default('');  // qrcode
            $table->text('desc')->nullable();       //
            $table->string('uid')->default('');
            $table->string('biz')->default('');     // biz id
            $table->integer('elite')->default(1);   // 推荐级别
            $table->integer('status')->default(1);  // 状态
            $table->integer('reg_type')->default(0); // 1 个人, 2 公司
            $table->string('reg_owner')->default('');
            $table->timestamp('reg_time')->nullable();
            $table->integer('fans_number')->default(0);
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
        Schema::drop('wx_site');
    }
}
