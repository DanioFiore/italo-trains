<?php

namespace App\Models;

use App\Models\Station;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Train extends Model
{
    use HasFactory;

    protected $table = 'trains';
    protected $primaryKey = 'id';

    protected $fillable = ['number', 'departure_place', 'departure_time', 'departure_date', 'arrival_place', 'arrival_time', 'delay'];

    public function stations() {
        return $this->hasMany(Station::class);
    }
}
