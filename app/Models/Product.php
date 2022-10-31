<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop;
use App\Models\SecondaryCategory;
use App\Models\Image;
use App\Models\Stock;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'information',
      'price',
      'is_selling',
      'sort_order',
      'shop_id',
      'secondary_category_id',
      'image1',	
      'image2',	
      'image3',	
      'image4',	
    ];

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
    public function imageSecond()
    {
      return $this->belongsTo(Image::class, 'image2', 'id');//リレーション 1対1の設定方法(エロクアント) 計2ヶ所
    }
    public function imageThird()
    {
      return $this->belongsTo(Image::class, 'image3', 'id');//リレーション 1対1の設定方法(エロクアント) 計2ヶ所
    }
    public function imageFourth()
    {
      return $this->belongsTo(Image::class, 'image4', 'id');//リレーション 1対1の設定方法(エロクアント) 計2ヶ所
    }
    
    public function stock()
    {
        return $this->hasMany(Stock::class);
    }
  }
