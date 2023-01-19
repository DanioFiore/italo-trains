<?php

namespace App\Models;

use App\Models\Train;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Station extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'arrival_time', 'departure_time'];

    public function trains() {
        return $this->belongsToMany(Train::class);
    }
}
