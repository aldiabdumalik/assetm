<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackingListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packing_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable();
            $table->foreignId('regional_id')
                ->nullable();
            $table->foreignId('branch_id')
                ->nullable();
            $table->string('pl_code')
                ->nullable();
            $table->string('pl_type');
            $table->tinyInteger('pl_status')
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
        Schema::dropIfExists('packing_lists');
    }
}
