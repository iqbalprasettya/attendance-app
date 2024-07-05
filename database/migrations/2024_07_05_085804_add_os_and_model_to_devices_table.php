<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_os_and_model_to_devices_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOsAndModelToDevicesTable extends Migration
{
    public function up()
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->string('os')->after('platform');
            $table->string('model')->after('device');
        });
    }

    public function down()
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('os');
            $table->dropColumn('model');
        });
    }
}
