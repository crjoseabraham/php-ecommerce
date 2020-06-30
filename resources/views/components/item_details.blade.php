<div class="item-details">
    <div class="item-details__picture">
        <img src="./img/product/{{ $product_id }}.jpg" alt="{{ $description }}">
    </div>
    <div class="item-details__info">
        <h3 class="sans fs16">{{ $description }}</h3>
        <h4 class="sans fs18 mt-2">${{ $price }}</h4>
        <button class="btn btn--primary"> Add to cart</button>
    </div>
</div>