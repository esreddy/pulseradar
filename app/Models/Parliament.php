<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parliament extends Model
{
    use HasFactory;
    protected $table = 'parliaments';
    protected $fillable = ['stateId', 'name'];

    // Define the relationship with State model
    public function state()
    {
        return $this->belongsTo(State::class, 'stateId', 'id');
    }
    public function assemblies()
    {
        return $this->hasMany(Assembly::class, 'parliamentId', 'id');
    }
}
