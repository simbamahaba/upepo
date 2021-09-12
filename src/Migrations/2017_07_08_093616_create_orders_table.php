<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('customer_id',false,true)->nullable();
            $table->decimal('price',10,2);
            $table->decimal('price_transport',10,2);
            $table->integer('transport_id',false,true)->nullable();
            $table->integer('quantity',false,true);
            $table->string('name')->nullable();
            $table->string('email');
            $table->tinyInteger('account_type');
            $table->string('phone',50)->nullable();
            $table->string('city',50)->nullable();
            $table->string('region',50)->nullable();
            $table->string('address',200)->nullable();
            $table->string('delivery_address',200);
            $table->string('cnp',100)->nullable();
            $table->string('company',50)->nullable();
            $table->string('rc',50)->nullable();
            $table->string('cif',50)->nullable();
            $table->string('bank_account',50)->nullable();
            $table->string('bank_name',50)->nullable();
            $table->integer('status_id',false,true)->nullable();
            $table->tinyInteger('read',false,true)->default(1);
            $table->timestamps();
        });
        if(Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
                $table->foreign('transport_id')->references('id')->on('transports')->onDelete('set null');
                $table->foreign('status_id')->references('id')->on('statuses')->onDelete('set null');
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
        Schema::dropIfExists('orders');
    }
}
