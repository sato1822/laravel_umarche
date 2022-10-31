<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    
    protected $table = 't_stocks';//table名の変更
    
    protected $fillable = [
      'product_id',
      'type',
      'quantity'
    ];
}
