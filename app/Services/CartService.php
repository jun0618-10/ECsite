<?php

namespace App\Services;
use App\Models\Product;
use App\Models\Cart; 

// class CartService
// {
//     public static function getItemsInCart($items)
//  {
//         $products = []; //空の配列を準備
//         foreach($items as $item){ // カート内の商品を一つずつ処理

//             $p = Product::findOrFail($item->product_id);
//             $owner = $p->shop->owner->select('name', 'email')->first()->toArray();//オーナー情報
//             $values = array_values($owner); //連想配列の値を取得
//             $keys = ['ownerName', 'email'];
//             $ownerInfo = array_combine($keys, $values); // オーナー情報のキーを変更
//             $product = Product::where('id', $item->product_id)
//             ->select('id', 'name', 'price')->get()->toArray(); // 商品情報の配列
//             $quantity = Cart::where('product_id', $item->product_id)
//             ->select('quantity')->get()->toArray(); // 在庫数の配列
//             $result = array_merge($product[0], $ownerInfo, $quantity[0]); // 配列の結合
//             array_push($products, $result); //配列に追加
        
//         }
//         return $products; // 新しい配列を返す
//  } 
// }



namespace App\Services;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Log;

class CartService
{
    public static function getItemsInCart($items)
    {
        $products = []; // 空の配列を準備

        foreach ($items as $item) {
            try {
                // 商品IDのnullチェック
                if ($item->product_id === null) {
                    continue; // null の場合はこのアイテムをスキップ
                }

                $p = Product::findOrFail($item->product_id);

                // オーナー情報の取得
                $ownerInfo = self::getOwnerInfo($p);

                // 商品情報の取得
                $product = Product::where('id', $item->product_id)
                    ->select('id', 'name', 'price')->first();

                if (!$product) {
                    continue; // 商品が見つからない場合はスキップ
                }

                $productArray = $product->toArray();

                // 在庫数の取得
                $quantity = Cart::where('product_id', $item->product_id)
                    ->select('quantity')->first();
                $quantityArray = $quantity ? $quantity->toArray() : ['quantity' => 0];

                // 結果の結合
                $result = array_merge($productArray, $ownerInfo, $quantityArray);
                $products[] = $result; // 配列に追加

            } catch (\Exception $e) {
                // エラーをログに記録
                Log::error('Error processing cart item: ' . $e->getMessage());
                // エラーが発生しても処理を続行
            }
        }

        return $products; // 新しい配列を返す
    }

    private static function getOwnerInfo($product)
    {
        try {
            if ($product->shop && $product->shop->owner) {
                $owner = $product->shop->owner->only(['name', 'email']);
                return [
                    'ownerName' => $owner['name'] ?? 'Unknown',
                    'email' => $owner['email'] ?? 'unknown@example.com'
                ];
            }
        } catch (\Exception $e) {
            Log::error('Error retrieving owner info: ' . $e->getMessage());
        }

        // デフォルト値を返す
        return [
            'ownerName' => 'Unknown',
            'email' => 'unknown@example.com'
        ];
    }
}
