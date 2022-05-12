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
        Schema::create('companies_packages', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->integer('company')->index();
            $table->integer('package')->index();
            $table->dateTime('expiration_date')->nullable();
            $table->timestamps();
        });

        Artisan::call('db:seed', array('--class' => 'CompaniesPackageSeeder'));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies_packages');
    }
};
