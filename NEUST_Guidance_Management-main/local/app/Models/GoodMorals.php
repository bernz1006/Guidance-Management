<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodMorals extends Model
{
    use HasFactory;
    protected $table = 'goodmoral_request';

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
