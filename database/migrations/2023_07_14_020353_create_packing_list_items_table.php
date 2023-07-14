<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackingListItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packing_list_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('packing_list_id')
                ->nullable();
            $table->foreignId('user_id')
                ->nullable();
            $table->foreignId('regional_id')
                ->nullable();
            $table->foreignId('model_id')
                ->nullable();
            $table->string('barcode');
            $table->string('mac');
            $table->tinyInteger('status_scan')
                ->default(0);
            $table->tinyInteger('delivery_status')
                ->default(0);
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
        Schema::dropIfExists('packing_list_items');
    }
}
