<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdereditemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordereditems', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('order_id',false,true);
            $table->integer('product_id',false,true)->nullable();
            $table->string('name',100);
            $table->decimal('price',10,2);
            $table->string('sku',50)->nullable();;
            $table->integer('quantity',false,true);
            $table->string('size',50)->nullable();;
            $table->string('color',50)->nullable();;
        });
        if(Schema::hasTable('ordereditems')) {
            Schema::table('ordereditems', function (Blueprint $table) {
                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
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
        Schema::dropIfExists('ordereditems');
    }
}
