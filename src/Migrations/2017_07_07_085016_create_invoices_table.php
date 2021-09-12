<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Simbamahaba\Upepo\Models\Invoice;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bank_name');
            $table->string('cif');
            $table->string('bank_account');
            $table->string('company');
            $table->string('region');
            $table->string('city');
            $table->string('rc');
            $table->string('address');
            $table->string('serie');
            $table->string('tva');
            $table->timestamps();
        });

        if(Schema::hasTable('invoices')){
            $invoice = new Invoice();
            $invoice->bank_name = 'Raiffeisen';
            $invoice->cif = '123123';
            $invoice->bank_account = 'RO58BRDE140SV222227';
            $invoice->company = 'Nume firma';
            $invoice->region = 'Bucuresti';
            $invoice->city = 'Bucuresti';
            $invoice->rc = 'J13/2944/12.12.2013';
            $invoice->address = 'Strada ... nr.1';
            $invoice->serie = '1234';
            $invoice->tva = '19';
            $invoice->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
