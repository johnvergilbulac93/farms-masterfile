<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCheck extends Model
{
    use HasFactory;
    protected $table = 'item_checks';
    protected $fillable = ['bu_id', 'itemcode'];
}
