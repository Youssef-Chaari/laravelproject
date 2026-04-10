<?php

namespace App\Models;

use Database\Factories\CarNewFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarNew extends Model
{
    use HasFactory;

    protected static function newFactory() { return CarNewFactory::new(); }

    protected $table = 'cars_new';

    protected $fillable = [
        'brand',
        'model',
        'year',
        'price',
        'description',
        'horsepower',
        'fuel_type',
        'transmission',
        'thumbnail',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'year'  => 'integer',
    ];

    public function images()
    {
        return $this->morphMany(CarImage::class, 'imageable');
    }

    public function primaryImage()
    {
        return $this->morphOne(CarImage::class, 'imageable')->where('is_primary', true);
    }
}
