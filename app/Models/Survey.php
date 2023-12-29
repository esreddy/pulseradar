<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $table = 'surveys'; // Specify the correct table name

    const CREATED_AT = 'createdDate'; // Define the column name for created timestamp
    const UPDATED_AT = 'modifiedDate'; // Define the column name for updated timestamp

    
}
