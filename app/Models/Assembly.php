<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assembly extends Model
{
    use HasFactory;

    protected $table = 'assemblies';

    protected $fillable = ['stateId', 'name', 'parliamentId'];

    // Define the relationship with State model
    public function state()
    {
        return $this->belongsTo(State::class, 'stateId', 'id');
    }

   // $assembly = Assembly::find($assemblyId);
    //$stateOfAssembly = $assembly->state; // Access the associated State model

}
