<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScanningItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scanning_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable();
            $table->foreignId('arrival_item_id')
                ->nullable();
            $table->foreignId('model_id')
                ->nullable();
            $table->string('scan_box');
            $table->string('scan_sn');
            $table->string('scan_mac');
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
        Schema::dropIfExists('scanning_items');
    }
}
