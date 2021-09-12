<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysShopSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_shop_setups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('action',100);
            $table->string('value')->nullable();
            $table->timestamps();
        });

        if( Schema::hasTable('sys_shop_setups') ){
            DB::table('sys_shop_setups')->insert([
                ['action'=>'customers_per_page', 'value'=>'10'],
                ['action'=>'orders_per_page', 'value'=>'10'],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_shop_setups');
    }
}
