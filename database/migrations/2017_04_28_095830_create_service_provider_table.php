<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 创建服务商
 * Class CreateServiceProviderTable
 */
class CreateServiceProviderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_provider', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',255)->comment("服务商");
            $table->string('mobile',11)->comment("联系方式");
            $table->tinyInteger('priority')->comment("优先级");
            $table->string('province',20)->comment("省");
            $table->string('city',100)->comment("城市");
            $table->string('district',50)->comment("区");
            $table->string('street',255)->comment("街道");
            $table->string('road',255)->comment("路");

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
        Schema::dropIfExists('service_provider');
    }
}
