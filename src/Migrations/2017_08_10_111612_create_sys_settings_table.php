<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('value');
            $table->integer('category',false,true);
        });

        if( Schema::hasTable('sys_settings') ){
            DB::table('sys_settings')->insert([
              ['name'=>'city','value'=>'Constanta','category'=>1],
              ['name'=>'contact_email','value'=>'contact.mail@example.com','category'=>1],
              ['name'=>'system_email','value'=>'system.mail@example.com','category'=>1],
              ['name'=>'phone','value'=>'0770111222','category'=>1],
              ['name'=>'site_name','value'=>'SiteName','category'=>2],
              ['name'=>'analytics','value'=>'(code)','category'=>3],
              ['name'=>'meta_keywords','value'=>'keyword1,keyword2,...','category'=>1],
              ['name'=>'meta_description','value'=>'Meta description - 180 chars...','category'=>1],
              ['name'=>'facebook_address','value'=>'my.fb.address','category'=>4],
              ['name'=>'twitter_address','value'=>'twitteraddress','category'=>4],
              ['name'=>'google_plus','value'=>'123123123','category'=>4],
              ['name'=>'youtube','value'=>'myyoutube','category'=>4],
              ['name'=>'pinterest','value'=>'www.pinterest.com/user','category'=>4],
              ['name'=>'og_pic','value'=>'og_pic.jpg','category'=>4],
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
        Schema::dropIfExists('sys_settings');
    }
}
