<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessUnit extends Model
{
    use HasFactory;
    protected $table = 'business_units';
    protected $fillable = [
        'bu_code',
        'bu_name',
        'bu_type',
        'server',
        'bu_seq_code'

    ];
    public function customer()
    {
        return $this->belongsTo(BuCheck::class, 'id', 'bu_id');
    }
    public function supplier()
    {
        return $this->belongsTo(SupplierCheck::class, 'id', 'bu_id');
    }
    public function item()
    {
        return $this->belongsTo(ItemCheck::class, 'id', 'bu_id');
    }
    public function sequence()
    {
        return $this->belongsTo(Sequence::class, 'seq_id', 'id');
    }
}
