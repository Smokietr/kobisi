<?php

namespace Database\Seeders;

use App\Models\CompaniesPackage;
use App\Models\CompaniesPayments;
use App\Models\Packages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompaniesPaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompaniesPackage::all()->each(function ($company) {
            CompaniesPayments::create([
                'company' => $company->company,
                'status' => rand(0, 1) ? 'success' : 'failed',
                'amount' => Packages::find($company->package)->amount,
                'package' => $company->package
            ]);
        });
    }
}
