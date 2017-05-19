<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 创建短信发送表
 * Class CreateSmsSendTable
 */
class CreateSmsSendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_send', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile',11)->comment("去电号码");
            $table->string('content',255)->comment("内容");
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
        Schema::dropIfExists('sms_send');
    }
}
