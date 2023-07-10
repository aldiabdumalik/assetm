<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArrivalItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrival_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable();
            $table->foreignId('branch_id')
                ->nullable();
            $table->string('regional_desc');
            $table->string('branch_desc');
            $table->string('delivery_pic');
            $table->string('user_pic');
            $table->date('arrival_date');
            $table->double('arrival_total');
            $table->text('arrival_note');
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
        Schema::dropIfExists('arrival_items');
    }
}
