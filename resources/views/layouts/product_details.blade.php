<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="icon" type="image/png" href="img/brand/favicon.png" />
        <link rel="stylesheet" href="dist/assets/styles/glider.min.css" />
        <link rel="stylesheet" href="dist/assets/styles/main.css" />
        <title>
            {{ $item->description }} | About the Fit
        </title>
    </head>

    <body id="bodyJsPointer">
        <!-- Notification -->
        @include('components.notification')
        <!-- Overlay -->
        <div id="overlay"></div>
        <!-- Navigation bar -->
        @include('sections.navbar')

        <!--                Product details                     -->
        <div class="container">
            <div class="product-container">
                <div class="product-container__img">
                    <img src="./img/product/{{ $item->product_id }}.jpg" alt="{{ $item->description }}">
                </div>
                <div class="product-container__details">
                    <h2 class="sans">{{ $item->description }}</h2>
                    <p class="product-code">Code: {{ $item->product_id }}</p>
                    <div class="product-price mt-2">
                        @if ($item->discount > 0)
                        <h2 class="price-to-show sans">
                            ${{ App\Controller\Merchandise\Products::calculateDiscount($item) }}
                        </h2>
                        <h3 class="original-price sans">
                            (lowered from ${{ $item->price }})
                        </h3>
                        @else
                        <h2 class="price-to-show sans">${{ $item->price }}</h2>
                        @endif
                    </div>
                    <p class="description mt-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio voluptatum excepturi ex sequi impedit odio voluptas eaque, doloremque deleniti assumenda!</p>

                    <!-- "Add to cart" form start -->
                    <form action="add-to-cart.{{ $item->product_id }}" method="post" id="add-to-cart">
                        @if (!empty($item->sizes))
                        <div class="sizes mt-2 form-group">
                            <h5 class="details-title sans">Select your size:</h5> <br>
                            <div class="input-group">
                            @foreach ($item->sizes as $size)
                                <input type="radio" name="size" id="size-{{ $size }}" value="{{ $size }}">
                                <label for="size-{{ $size }}">{{ $size }}</label>
                            @endforeach
                            </div>
                            <p class="input-errors">
                                Please select a size
                            </p>
                        </div>
                        @endif

                        <h5 class="details-title mt-2 sans">Select quantity:</h5>
                        <select name="quantity" id="quantity-selectbox">
                            @for ($i = 1; $i <= 20; $i++)
                                @if ($i === 1)
                                <option value="{{ $i }}" selected> {{ $i }} </option>
                                @else
                                <option value="{{ $i }}"> {{ $i }} </option>
                                @endif
                            @endfor
                        </select>

                        <button type="submit" class="btn btn--primary mt-2">
                            <i class="fas fa-shopping-bag"></i>
                            &nbsp; Add to cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <!--                Product details end                 -->

        <!-- Footer -->
        @include('sections.footer')
        <script
            src="https://kit.fontawesome.com/eea5dcc8ef.js"
            crossorigin="anonymous"
        ></script>
        <script src="dist/assets/js/app.js"></script>
    </body>
</html>