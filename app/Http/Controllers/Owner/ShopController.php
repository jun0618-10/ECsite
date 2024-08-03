<?php

namespace App\Http\Controllers\Owner;

use App\Models\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UploadImage;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use App\Services\ImageService;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->Middleware('auth:owners');

        //TODO　下記のコードの意味を聞く
        $this->Middleware(function($request, $next){
            $id = $request->route()->parameter('shop');
            if(!is_null($id)){
                $shopOwnerId = shop::findOrFail($id)->owner->id;
                $shopId =(int)$shopOwnerId;
                $ownerId = Auth::id();
                if($shopId !== $ownerId){
                    abort(404);
                }
            }
            return $next($request);
        });
    }

    public function index()
    {
        //guardに登録したproviderを経由してownerIdを取得
        $ownerId = Auth::id();
        $shops = Shop::where('owner_id', $ownerId)->get();

        return view('owner.shops.index', compact('shops'));
    }

    public function edit($id)
    {
        $shop = Shop::findOrFail($id);

        return view('owner.shops.edit', compact('shop'));

    }

    // public function update(UploadImage $request, $id)
    // {
    //     $imageFile = $request->image;
    //     if(!is_null($imageFile) && $imageFile->isValid()){
    //         // Storage::putFile('public/shops', $imageFile);　リサイズ無し

    //         $manager = new ImageManager(new Driver());
    //         $fileName = uniqid(rand().'_');
    //         $extension = $imageFile->extension();
    //         $fileNameToStore = $fileName . '.' . $extension;
    //         $resizedImage = $manager->read($imageFile)
    //             ->resize(1920, 1080)
    //             ->encode($extension);
    //         dd($imageFile, $resizedImage);

    //         Storage::put('public/shops/' . $fileNameToStore, $resizedImage);
    //     }

    //     return redirect()->route('owner.shops.index');

    // }



public function update(UploadImage $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:50',
        'information' => 'required|string|max:1000|',
        'is_selling' => 'required',
    ]);

    $imageFile = $request->file('image');
    if ($imageFile && $imageFile->isValid()) {
       $fileNameToStore = ImageService::upload($imageFile, 'shops');
    }

    $shop = Shop::findOrFail($id);
    $shop->name = $request->name;
    $shop->information = $request->information;
    $shop->is_selling = $request->is_selling;
    if($imageFile && $imageFile->isValid()){
        $shop->filename = $fileNameToStore;
    }

    $shop->save();

    return redirect()
    ->route('owner.shops.index')
    ->with(['message'=>'店舗情報情報を更新しました。',
    'status' => 'info']);
}
}
