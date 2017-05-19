<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 创建短信接收表
 * Class CreateSmsSendReceive
 */
class CreateSmsReceiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_receive', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile',11)->comment("来电号码");
            $table->string('content',255)->comment("短信内容");
            $table->integer('send_id')->default('0')->comment("发送表对应id");
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
        Schema::dropIfExists('sms_receive');
    }
}
