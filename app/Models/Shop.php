<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Owner;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
      'owner_id',
      'name',
      'information',
      'filename',
      'is_selling',
  ];

    public function owner()
    {
      return $this->belongsTo(Owner::class);//リレーション 1対1の設定方法(エロクアント) 計2ヶ所
    }
}
