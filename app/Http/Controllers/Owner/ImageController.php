<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UploadImageRequest;
use App\Services\ImageService;


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
      ->orderBy('created_at', 'desc')//取得して表示される順番が逆になる
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
