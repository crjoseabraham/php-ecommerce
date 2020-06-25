<div class="product__card">
    <div class="product__image">
        <img src="./img/product/{{ $item["product_id"] }}.jpg" alt="Product Image">
        <div class="image__overlay"></div>
        <button class="btn btn--blank transparent mt-2">View details</button>
    </div>

    <div class="product__details">
        <span class="product__name">{{ $item["description"] }}</span>
        <div class="product__price">
            @if ($item["discount"] > 0)
                <span class="product__price--with-discount">
                    $ {{ $item["price"] - ($item["price"] * ($item["discount"] / 100)) }}
                </span>
                <span class="product__price--original stroked">$ {{ $item["price"] }}</span>
            @else
                <span class="product__price--original">$ {{ $item["price"] }}</span>
            @endif
        </div>
    </div>
</div>