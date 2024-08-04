<p class="mb-4">{{ $product['ownerName'] }}様</p>

<div class="mb-4">商品情報</div>

商品内容

<ul class="mb-4">
    <li>{{ $product['name'] }}</li>
    <li>{{ number_format($product['price']) }}</li>
    <li>{{ $product['quantity'] }}</li>
    <li>{{ number_format($product['price'] * $product['quantity'])  }}円</li>
</ul>


<div class="mb-4">購入者情報</div>
<ul>
    <li>{{ $user->name }}様</li>
</ul>



