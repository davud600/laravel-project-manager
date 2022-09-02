<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeEstimatedTime extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'employee_id',
        'project_id',
        'time_added',
        'created_by_admin'
    ];
}
