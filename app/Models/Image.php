<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Owner;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
      'owner_id',
      'filename',
    ];

    public function owner()
    {
      return $this->belongsTo(Owner::class);//リレーション 1対1の設定方法(エロクアント) 計2ヶ所
    }
}
