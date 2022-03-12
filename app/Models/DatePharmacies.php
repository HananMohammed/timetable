<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatePharmacies extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_id',
        'pharmacy_id',
        'time_from',
        'time_to',
        'from_slot',
        'to_slot',
    ];
}
