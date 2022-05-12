<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Companies extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $casts = [
        'status' => 'boolean'
    ];

    protected $appends = [
        'remaining'
    ];

    protected $with = [
        'packages',
    ];

    public function packages() {
        return $this->belongsToMany(Packages::class, 'companies_packages', 'company', 'package', 'id');
    }

    public function getRemainingAttribute() {
        return function () {
            return $this->packages()->first()->created_at;
        };
    }

    public function buy() {
        return $this->hasOne(CompaniesPayments::class, 'company', 'id');
    }
}
