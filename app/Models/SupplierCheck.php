<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierCheck extends Model
{
    use HasFactory;
    protected $table = 'sup_checks';
    protected $fillable = [
        'bu_id', 'sup_code', 'status'
    ];
}
