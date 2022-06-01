<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 100);
            $table->unsignedTinyInteger('visible')->default(1);
            $table->unsignedInteger('order');
            $table->timestamps();
        });

        if( Schema::hasTable('statuses')){
            DB::table('statuses')->insert([
                ['name' => 'Comandă plasată', 'order' => 1],
                ['name' => 'Comandă procesată', 'order' => 2],
                ['name' => 'Comandă expediată', 'order' => 3],
                ['name' => 'Comandă finalizată', 'order' => 4],
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
        Schema::dropIfExists('statuses');
    }
}
