<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'country',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($guest) {
            if (empty($guest->country)) {
                $guest->country = self::determineCountry($guest->phone);
            }
        });
    }

    private static function determineCountry($phone)
    {
        if (strpos($phone, '+7') === 0) {
            return 'Россия';
        }

        return 'Неизвестно';
    }
}
