<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Shop;
use App\Models\Image;

class Owner extends Authenticatable
{
    use HasFactory, SoftDeletes;//ソフトディリートして扱われる
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'name',
      'email',
      'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
      'password',
      'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
      'email_verified_at' => 'datetime',
  ];

  public function shop()
  {
    return $this->hasOne(Shop::class);// リレーション 1対1の設定方法(エロクアント) 計2ヶ所
  }

  public function image()
  {
    return $this->hasMany(Image::class);// リレーション 1対1の設定方法(エロクアント) 計2ヶ所
  }
}
