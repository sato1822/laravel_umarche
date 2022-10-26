<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop;
use App\Models\SecondaryCategory;
use App\Models\Image;

class Product extends Model
{
    use HasFactory;

    public function shop()
    {
      return $this->belongsTo(Shop::class);//リレーション 1対1の設定方法(エロクアント) 計2ヶ所
    }

    public function category()
    {
      return $this->belongsTo(SecondaryCategory::class, 'secondary_category_id');//リレーション 1対1の設定方法(エロクアント) 計2ヶ所
    }

    public function imageFirst()
    {
      return $this->belongsTo(Image::class, 'image1', 'id');//リレーション 1対1の設定方法(エロクアント) 計2ヶ所
    }
}
