<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';

    protected $fillable = [
        'fullname',
        'phonenumber',
        'email',
        'password',
    ];

    protected $hidden = [
        'password'
    ];

    public function redemptions()
    {
        return $this->hasMany(Redemption::class);
    }

    public function points()
    {
        return $this->hasOne(Point::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}