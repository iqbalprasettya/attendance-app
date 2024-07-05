<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_device_name_and_brand_to_devices_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeviceNameAndBrandToDevicesTable extends Migration
{
    public function up()
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->string('device_name')->after('device');
            $table->string('device_brand')->after('device_name');
        });
    }

    public function down()
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('device_name');
            $table->dropColumn('device_brand');
        });
    }
}
