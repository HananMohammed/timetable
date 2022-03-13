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

    public function scopeFilter($query,$req){
        $query->when((($req->has('start_date') && $req->start_date != null) || ($req->has('start_date') && $req->start_date != ''))
            && (($req->has('end_date') && $req->end_date != null) || ($req->has('end_date') && $req->end_date != '')),function ($q)use($req){
            $q->whereBetween('date',[Carbon::parse($req['start_date'])->format('Y-m-d'),Carbon::parse($req['end_date'])->format('Y-m-d')])
                ->orWhereRaw('DATE(date) = ?', [Carbon::parse($req['start_date'])])
                ->orWhereRaw('DATE(date) = ?', [Carbon::parse($req['end_date'])]);
        })
        ->when(($req->has('pharmacy_id') && $req->pharmacy_id != null), function ($q) use($req){
            $q->whereHas('pharmacies', function ($query) use($req){
                 $query->where('date_pharmacies.pharmacy_id', $req->pharmacy_id);
            });
        } );
        return $query;

    }
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

    public function pharmacies(){
        return  $this->hasMany(DatePharmacies::class, 'date_id');
    }
}
