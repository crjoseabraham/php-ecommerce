<section class="container best-sellers">
    <div class="carousel-group">
        <h4 class="section-title">Best Sellers</h4>

        <div class="glider-contain multiple-items mt-2">
            <div class="best-sellers-carousel glider-wrap">
                @foreach ($products as $item)
                    @include('components.product_card')
                @endforeach
            </div>

            <button aria-label="Previous" class="glider-prev best-prev">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button aria-label="Next" class="glider-next best-next">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <div class="carousel-group">
        <h4 class="section-title">New Arrivals</h4>

        <div class="glider-contain multiple-items mt-2">
            <div class="just-arrived-carousel glider-wrap">
                @foreach ($products2 as $item)
                    @include('components.product_card')
                @endforeach
            </div>

            <button aria-label="Previous" class="glider-prev ja-prev">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button aria-label="Next" class="glider-next ja-next">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>