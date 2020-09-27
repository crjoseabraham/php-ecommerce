<a href="product_details.{{ $item->product_id }}">
    <div class="product__card">
        <div class="product__card-image-container">
            @if ($item->discount > 0)
            <span class="discount-badge">
                {{ $item->discount }}% <br> <p>OFF</p>
            </span>
            @endif
            <img src="./img/product/{{ $item->product_id }}.jpg" alt="{{ $item->description}}">
        </div>

        <div class="product__card-details-container">
            <p class="description">{{ $item->description }}</p>
            <div class="price-container">
                @if ($item->discount > 0)
                    <span class="price-with-discount">
                        ${{ App\Controller\Merchandise\Products::calculateDiscount($item) }}
                    </span>
                    <span class="original-price">(lowered from ${{ $item->price }})</span>
                @else
                    <span class="original-price">${{ $item->price }}</span>
                @endif
            </div>
        </div>
    </div>
</a>