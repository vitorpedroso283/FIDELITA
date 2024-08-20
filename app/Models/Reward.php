<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $table = 'reward';

    protected $fillable = [
        'name',
        'required_points',
    ];

    public function redemptions()
    {
        return $this->hasMany(Redemption::class);
    }
}