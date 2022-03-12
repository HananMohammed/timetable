<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date'
    ];

    /**
     * Interact with the user's Created at.
     *
     * @return Attribute
     */
    protected function createdAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Carbon::parse($value)->format('Y-m-d'),
        );
    }

    /**
     * Interact with the user's Created at.
     *
     * @return Attribute
     */
    protected function date(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Carbon::parse($value)->format('d M Y'),
        );
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function datePharmacies(){
        return $this->hasMany(DatePharmacies::class, 'pharmacy_id');
    }
}
