<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'valid_from',
        'valid_until',
        'max_uses',
        'times_used'
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date'
    ];

    public function isValid()
    {
        $now = now();
        return $this->valid_from <= $now &&
               $this->valid_until >= $now &&
               ($this->max_uses === null || $this->times_used < $this->max_uses);
    }
} 