<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->tinyInteger('account_type')->default(0);
            $table->string('phone',50)->nullable();
            $table->string('city',50)->nullable();
            $table->string('region',50)->nullable();
            $table->string('address',200)->nullable();
            $table->string('cnp',100)->nullable();
            $table->string('company',50)->nullable();
            $table->string('rc',50)->nullable();
            $table->string('cif',50)->nullable();
            $table->string('bank_account',50)->nullable();
            $table->string('bank_name',50)->nullable();
            $table->tinyInteger('visible')->default(0);
            $table->integer('order')->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->unique()->nullable();
            $table->tinyInteger('verified')->default(0); // this column will be a TINYINT with a default value of 0 , [0 for false & 1 for true i.e. verified]
            $table->string('email_token')->nullable(); // this column will be a VARCHAR with no default value and will also BE NULLABLE
            $table->rememberToken();
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
        Schema::dropIfExists('customers');
    }
}
