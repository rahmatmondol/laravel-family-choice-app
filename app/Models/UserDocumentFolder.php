<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocumentFolder extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'user_id',
    ];

    //
    public function documents()
    {
        return $this->hasMany(CustoemrDocument::class);
    }

    //
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
