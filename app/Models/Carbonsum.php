<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carbonsum extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'accumulated_works_carbon',
        'accumulated_foods_carbon',
        'accumulated_move_carbon',
        'accumulated_life_carbon',
        'accumulated_total_carbon'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
