<?php

namespace App\Models;

use Database\Factories\CarUsedFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarUsed extends Model
{
    use HasFactory, SoftDeletes;

    protected static function newFactory() { return CarUsedFactory::new(); }

    protected $table = 'cars_used';

    protected $fillable = [
        'user_id',
        'brand',
        'model',
        'year',
        'price',
        'mileage',
        'description',
        'status',
    ];

    protected $casts = [
        'price'   => 'decimal:2',
        'year'    => 'integer',
        'mileage' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->morphMany(CarImage::class, 'imageable');
    }

    public function primaryImage()
    {
        return $this->morphOne(CarImage::class, 'imageable')->where('is_primary', true);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
