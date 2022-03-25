<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    protected  $fillable = ['path'];

    public $directory = "/images/";

    public function getPathAttribute($value)
    {
        return $this->directory . $value;
    }



}
