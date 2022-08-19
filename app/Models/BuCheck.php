<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuCheck extends Model
{
    use HasFactory;
    protected $table = 'bu_checks';
    protected $fillable = [
        'bu_id', 'cus_code', 'status'
    ];
}
