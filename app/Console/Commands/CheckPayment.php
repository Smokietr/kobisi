<?php

namespace App\Console\Commands;

use App\Models\CompaniesPayments;
use Illuminate\Console\Command;

class CheckPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily Check Payment';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        CompaniesPayments::whereStatus(false)->get()->each(function ($payment) {
            if(substr(rand(), -1) % 2 == 0) {
                $payment->update([
                    'status' => true
                ]);
            }
        });

        return 0;
    }
}
