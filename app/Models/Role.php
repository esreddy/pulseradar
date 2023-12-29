<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // Fillable fields in the Role model

    // Define any relationships if needed, e.g., if a role has many employees
    public function employees()
    {
        //return $this->hasMany(Employee::class);
        return $this->hasMany(Employee::class, 'roleId', 'uuid');
    }

}
