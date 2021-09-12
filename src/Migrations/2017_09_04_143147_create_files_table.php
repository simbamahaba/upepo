<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('table_id', false, true);
            $table->integer('record_id', false, true);
            $table->integer('ordine', false, true)->nullable();
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->timestamps();
        });
        if(Schema::hasTable('files')) {
            Schema::table('files', function (Blueprint $table) {
                $table->foreign('table_id')->references('id')->on('sys_core_setups')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
