<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('table_id', false, true);
            $table->integer('record_id', false, true);
            $table->integer('ordine', false, true)->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        if(Schema::hasTable('images')) {
            Schema::table('images', function (Blueprint $table) {
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
        Schema::dropIfExists('images');
    }
}
