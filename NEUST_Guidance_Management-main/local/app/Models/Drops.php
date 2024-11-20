<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drops extends Model
{
    use HasFactory;

    protected $table = 'drop_request';

    protected $fillable = [
        'request_type',
        'student_id',
        'request_date',
        'reason',
        'status',
        'notes',
        'isActive',
        'counselor_id',
    ];
}
