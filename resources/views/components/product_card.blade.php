<div class="product__card" data-popup="item/{{ $item["product_id"] }}/details" data-http="true">
    <div class="product__card-image-container">
        <img src="./img/product/{{ $item["product_id"] }}.jpg" alt="{{ $item["description"]}}">
        <button class="btn btn--primary" data-popup="item/{{ $item["product_id"] }}/details" data-http="true">
            View details
        </button>
    </div>

    <div class="product__card-details-container">
        <p class="description">{{ $item["description"] }}</p>
        <div class="price-container">
            @if ($item["discount"] > 0)
                <span class="price-with-discount">
                    $ {{ $item["price"] - ($item["price"] * ($item["discount"] / 100)) }}
                </span>
                <span class="original-price stroked">$ {{ $item["price"] }}</span>
            @else
                <span class="original-price">$ {{ $item["price"] }}</span>
            @endif
        </div>
    </div>
</div>