<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testing_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable();
            $table->foreignId('regional_id')
                ->nullable();
            $table->foreignId('type_id')
                ->nullable();
            $table->foreignId('model_id')
                ->nullable();
            $table->string('barcode');
            $table->tinyInteger('status');
            $table->string('box_ok');
            $table->string('box_nok');
            $table->string('type_desc');
            $table->string('brand_desc');
            $table->string('model_desc');
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
        Schema::dropIfExists('testing_items');
    }
}
