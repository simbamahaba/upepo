<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysGoogleMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_google_maps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('latitude',50);
            $table->string('longitude',50);
            $table->string('company',200);
            $table->string('region',200);
            $table->string('city',200);
            $table->string('address',200);
            $table->timestamps();
        });
        if( Schema::hasTable('sys_google_maps') ){
            DB::table('sys_google_maps')->insert([
                [
                    'id'=>1,
                    'latitude'=>44.206966,
                    'longitude'=>28.643729,
                    'company'=>'NumeFirma',
                    'region'=>'Constanta',
                    'city'=>'Constanta',
                    'address'=>'Strada NumeStrada nr.22',
                ],
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
        Schema::dropIfExists('sys_google_maps');
    }
}
