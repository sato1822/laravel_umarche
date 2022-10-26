<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PrimaryCategory;

class SecondaryCategory extends Model
{
    use HasFactory;

    public function primary()
    {
      return $this->belongsTo(PrimaryCategory::class);//リレーション 1対1の設定方法(エロクアント) 計2ヶ所
    }
}
