<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarImage extends Model
{
    protected $table = 'car_images';

    protected $fillable = ['imageable_type', 'imageable_id', 'path', 'is_primary'];

    public function imageable()
    {
        return $this->morphTo();
    }
}
