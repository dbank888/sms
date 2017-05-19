<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 创建公司表
 * Class CreateCompanyTable
 */
class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',255)->comment("公司名称");
            $table->string('car_id',100)->comment("车架号");
            $table->string('license',20)->comment("车牌号");
            $table->integer('service_id')->comment("服务商id");
            $table->string('mobile',11)->comment("服务商联系方式(冗余)");
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
        Schema::dropIfExists('company');
    }
}
