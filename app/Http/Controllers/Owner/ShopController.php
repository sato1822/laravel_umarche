<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use InterventionImage;
use App\Http\Requests\UploadImageRequest;
use App\Services\ImageService;

class ShopController extends Controller
{
    //
    public function __construct()
    {
      $this->middleware('auth:owners');

      $this->middleware(function ($request, $next) {
      // dd($request->route()->parameter('shop')); //文字列
      // dd(Auth::id()); //数字

        $id = $request->route()->parameter('shop');//shopのIdの取得(現在文字列での取得状態) 
        if(!is_null($id)){//空でなかったら
          $shopsOwnerId = Shop::FindOrFail($id)->owner->id;//オーナーのIdの取得
          $shopId = (int)$shopsOwnerId;//文字列から数値に変換
          $ownerId = Auth::id();
          if($shopId !== $ownerId){//同じでなかったら
            abort(404);//404 非表示画面の表示
          }
        }
        return $next($request);
    });
    }

    public function index()
    {
      // phpinfo();
      // $ownerId = Auth::id();
      $shops = Shop::where('owner_id', Auth::id())->get();

      return view('owner.shops.index', compact('shops'));
    }

    public function edit($id)
    {
      $shop = Shop::findOrFail($id);
      // dd(Shop::FindOrFail($id));
      return view('owner.shops.edit', compact('shop'));
    }

    public function update(UploadImageRequest $request, $id)//requestで指定してバリデーションが使える
    {
      $imageFile = $request->image;
      if(!is_null($imageFile) && $imageFile->isValid()){
        $fileNameToStore = ImageService::upload($imageFile, 'shops');
        // Storage::putFile('public/shops', $imageFile); //putfileはファイルを想定しているのでリサイズがなしでファイルに保存ができる
        // $filename = uniqid(rand(), '_');
        // $extension = $imageFile->extension();
        // $fileNameToStore = $filename . '.' . $extension;
        // $resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode();
        // // dd($imageFile, $resizedImage);

        // Storage::put('public/shops/' . $fileNameToStore, $resizedImage);
      }
      return redirect()->route('owner.shops.index');
    }
}
