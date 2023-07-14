<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('packing_list_id')
                ->nullable();
            $table->foreignId('delivery_branch_id')
                ->nullable();
            $table->foreignId('user_id')
                ->nullable();
            $table->string('delivery_no');
            $table->string('delivery_resi');
            $table->integer('jml_item');
            $table->date('estimasi');
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
        Schema::dropIfExists('deliveries');
    }
}
