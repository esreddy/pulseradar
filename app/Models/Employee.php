<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;


    protected $table = 'employees'; // Specify the correct table name

    const CREATED_AT = 'createdDate'; // Define the column name for created timestamp
    const UPDATED_AT = 'modifiedDate'; // Define the column name for updated timestamp


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */
    protected $fillable = [
        'name',
        'mobileNumber',
        'password',
    ];

    public function role()
    {
        //return $this->belongsTo(Role::class, 'roleId');
        return $this->belongsTo(Role::class, 'roleId', 'uuid');
    }
    public function parent()
    {
        return $this->belongsTo(Employee::class, 'parentId');
    }
    function viewEmployees()
    {

        //$records = Employee::with('role')->paginate(4);
        $records = Employee::with(['role', 'parent'])->paginate(4);

        return view('employees',compact('records'));
    }



}
