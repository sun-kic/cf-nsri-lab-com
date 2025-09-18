<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'prefecture',
        'sex',
        'age',
        'house_type',
        'house_build_year',
        'house_area',
        'year_month',
        'power_company',
        'power_amount',
        'power_kw',
        'gas_type',
        'gas_amount',
        'gas_m',
        'kerosine_amount',
        'kerosine_l',
        'house_number'
    ];

    
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    
}
