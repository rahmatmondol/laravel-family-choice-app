<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class CustoemrDocument extends Model
{
    use HasFactory;

    public function setTitleAttribute($value)
    {
        $this->attributes['Title'] = ucwords($value);
    }
    protected function frontSide(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value != null && file_exists('uploads/document/'.$value) ? asset('uploads/document/'.$value) : asset("uploads/document/170903095064.jpeg"),
        );
    }

    protected function backSide(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value != null && file_exists('uploads/document/'.$value) ? asset('uploads/document/'.$value) : asset("uploads/document/170903095064.jpeg"),
        );
    }

}
