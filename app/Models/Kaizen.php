<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kaizen extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kaizen_items',
        'kaizen_number',
        'kaizen_total'
    ];

    
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
