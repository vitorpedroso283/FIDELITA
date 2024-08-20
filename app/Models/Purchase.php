<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $table = 'purchase';

    protected $fillable = [
        'customer_id',
        'spent_value',
        'points',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}