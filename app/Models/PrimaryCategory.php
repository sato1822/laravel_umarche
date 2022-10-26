<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SecondaryCategory;

class PrimaryCategory extends Model
{
    use HasFactory;

    public function secondary()
    {
      return $this->hasMany(SecondaryCategory::class);// リレーション 1対1の設定方法(エロクアント) 計2ヶ所
    }
}
