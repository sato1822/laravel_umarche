<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UploadImageRequest;
use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:owners');

    $this->middleware(function ($request, $next) {

      $id = $request->route()->parameter('image');//shopのIdの取得(現在文字列での取得状態) 
      if(!is_null($id)){//空でなかったら
        $imagesOwnerId = Image::FindOrFail($id)->owner->id;//オーナーのIdの取得
        $imageId = (int)$imagesOwnerId;//文字列から数値に変換
        if($imageId !== Auth::id()){//同じでなかったら
          abort(404);//404 非表示画面の表示
        }
      }
      return $next($request);
  });
  }

    public function index()
    {
      $images = Image::where('owner_id', Auth::id())
      ->orderBy('updated_at', 'desc')//取得して表示される順番が逆になる
      ->paginate(20);
      return view('owner.images.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('owner.images.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UploadImageRequest $request)
    {
        $imageFiles = $request->file('files');
        if(!is_null($imageFiles)){
          foreach($imageFiles as $imageFile){
            $fileNameToStore = ImageService::upload($imageFile, 'products');
            Image::create([
              'owner_id' => Auth::id(),
              'filename' => $fileNameToStore
            ]);
          }
        }

        return redirect()
        ->route('owner.images.index')
        ->with(['message' => '画像登録を実施しました。','status' => 'info']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $image = Image::findOrFail($id);
      // dd(Shop::FindOrFail($id));
      return view('owner.images.edit', compact('image'));
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
      $request->validate([
        'title' => ['string', 'max:50'],
      ]);

      $image = Image::findOrFail($id);
      $image->title = $request->title;
      $image->save();

      return redirect()
      ->route('owner.images.index')
      ->with(['message' => '画像情報を更新しました。','status' => 'info']);
    }

    public function destroy($id)
    {
      $image = Image::findOrFail($id);//データ内の情報を削除する前にフォルダないの情報を削除する

      $imageProduct = Product::where('image1', $image->id)
      ->orWhere('image2', $image->id)
      ->orWhere('image3', $image->id)
      ->orWhere('image4', $image->id);

      if($imageProduct){
        $imageProduct->each(function($product) use ($image){
          if($product->image1 === $image->id){
            $product->image1 = null;
            $product->save();
          }
          if($product->image2 === $image->id){
            $product->image2 = null;
            $product->save();
          }
          if($product->image3 === $image->id){
            $product->image3 = null;
            $product->save();
          }
          if($product->image4 === $image->id){
            $product->image4 = null;
            $product->save();
          }
        });
      }

      $filePath = 'public/products/' . $image->filename;
      if(Storage::exists($filePath)){
        Storage::delete($filePath);
      }

      Image::findOrFail($id)->delete();//deleteメソッドの場合はソフトデリートになる

      return 
      redirect()
      ->route('owner.images.index')
      ->with(['message' => ' 画像を削除しました。',
      'status' => 'alert']);
    }
}
