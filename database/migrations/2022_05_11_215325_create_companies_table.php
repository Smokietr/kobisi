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
        Schema::create('companies', function (Blueprint $table) {
            $table->bigInteger('id')->index()->autoIncrement();

            $table->string('name');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('password');

            $table->string('company_name')->fulltext()->unique()->comment('company');
            $table->string('site_url')->nullable()->comment('company');

            $table->timestamps();
        });

        Artisan::call('db:seed', array('--class' => 'CompaniesSeeder'));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
