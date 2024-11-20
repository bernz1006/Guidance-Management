<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestHistory extends Model
{
    use HasFactory;
    protected $table = 'request_history';

    protected $fillable = [
        'request_type',
        'request_id',
        'student_id',
        'status',
        'total',
        'request_date',
    ];
}
