<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('company')->index();
            $table->enum('status', ['success', 'failed']);
            $table->string('invoice')->nullable();
            $table->float('amount', 8, 2)->nullable();
            $table->integer('package')->index();
            // card number etc..
            $table->timestamps();
        });

        Artisan::call('db:seed', array('--class' => 'CompaniesPaymentsSeeder'));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies_payments');
    }
};
