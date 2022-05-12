<?php

namespace Database\Seeders;

use App\Models\Companies;
use App\Models\CompaniesPackage;
use App\Models\CompaniesPayments;
use App\Models\Packages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CompaniesPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Companies::all()->each(function ($company) {

             $package = Packages::inRandomOrder()->first();

             CompaniesPackage::create([
                 'company' => $company->id,
                 'package' => $package->id,
                 'expiration_date' => Carbon::now()->addDays($package->day)->toDateTime()
             ]);

        });
    }
}
