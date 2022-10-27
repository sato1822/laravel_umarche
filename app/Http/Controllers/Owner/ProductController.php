<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;
use App\Models\Product;
use App\Models\SecondaryCategory;
use App\Models\Owner;

class ProductController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:owners');

    $this->middleware(function ($request, $next) {

      $id = $request->route()->parameter('product');//shopのIdの取得(現在文字列での取得状態) 
      if(!is_null($id)){//空でなかったら
        $productOwnerId = product::FindOrFail($id)->shop->owner->id;//オーナーのIdの取得
        $productId = (int)$productOwnerId;//文字列から数値に変換
        if($productId !== Auth::id()){//同じでなかったら
          abort(404);//404 非表示画面の表示
        }
      }
        return $next($request);
      });
  }

    public function index()
    {
        // $products = Owner::findOrFail(Auth::id())
        // ->shop->product;

        $ownerInfo = Owner::with('shop.product.imageFirst')
        //読み込む際にリレーションしているsqlまで読み込んでしまいうのを防ぐために
        //Eager loadingを使い一つにまとめて取得するkとおにより重諷誦するのを防ぐことができる

        ->where('id', Auth::id())
        ->get();

        // dd($ownerInfo);
        // foreach($ownerInfo as $owner)
        // {
        //   // dd($owner);
        //   foreach($owner->shop->product as $product)
        //   {
        //     dd($product->imageFirst->filename);
        //   }
        // }

        return view('owner.products.index', 
        compact('ownerInfo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
