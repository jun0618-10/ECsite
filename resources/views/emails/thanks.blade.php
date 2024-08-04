{{-- <p class="mb-4">{{ $user->name }}様</p>

<p class="mb-4">下記のご注文ありがとうございました。</p>

商品内容
@foreach($productsas $product)
<ul class="mb-4">
    <li>{{ $product['name'] }}</li>
    <li>{{ number_format($product['price']) }}</li>
    <li>{{ $product['quantity'] }}</li>
    <li>{{ number_format($product['price'] * $product['quantity'])  }}円</li>
</ul>


@endforeach --}}

<p class="mb-4">{{ $user->name }}様</p>

<p class="mb-4">下記のご注文ありがとうございました。</p>

商品内容
@foreach($products as $product)
<ul class="mb-4">
    <li>{{ $product['name'] }}</li>
    <li>{{ number_format($product['price']) }}円</li>
    <li>{{ $product['quantity'] }}個</li>
    <li>{{ number_format($product['price'] * $product['quantity']) }}円</li>
</ul>
@endforeach