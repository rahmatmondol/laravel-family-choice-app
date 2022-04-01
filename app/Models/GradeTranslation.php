<?php

namespace App\Models;

use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GradeTranslation extends Model
{
  use HasFactory;
  public $timestamps = false;
  protected $guarded = [];
}
