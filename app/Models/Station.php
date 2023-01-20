<?php

namespace App\Models;

use App\Models\Train;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Station extends Model
{
    use HasFactory;
    protected $table = 'stations';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'arrival_time', 'departure_time', 'train_id'];

    public function train() {
        return $this->belongsTo(Train::class);
    }
}
