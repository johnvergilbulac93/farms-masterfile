<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonTradeCustomer extends Model
{
    use HasFactory;
    protected $fillable = ['nav_code', 'cus_name', 'applied_to_bu'];
}
