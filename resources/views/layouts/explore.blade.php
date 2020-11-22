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
            Women's Clothing | About the fit
        </title>
    </head>

    <body id="bodyJsPointer">
        <!-- Notification -->
        @include('components.notification')

        <!-- Overlay -->
        <div id="overlay"></div>

        <!-- Navigation bar -->
        @include('sections.navbar')

        <!-- Main content -->
        <div class="container explore_page">
            <div class="explore_page__sidebar">
                <nav class="explore_page__navigation">
                    <ul>
                        <li>
                            @if ($selected_category === 0)
                            <strong>All</strong>
                            @else
                            <a href="explore-all" class="simple">All</a>
                            @endif
                        </li>
                        @foreach ($categories as $category)
                        <li>
                            @if ($selected_category == $category['id'])
                            <strong>{{$category['name']}}</strong>
                            @else
                            <a href="explore-{{strtolower($category['name'])}}" class="simple">{{ $category['name'] }}</a>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </nav>
            </div>

            <div class="explore_page__items">
                @foreach ($items as $item)
                    @include('components.product_card')
                @endforeach
            </div>
        </div>

        <!-- Footer -->
        @include('sections.footer')

        <script
            src="https://kit.fontawesome.com/eea5dcc8ef.js"
            crossorigin="anonymous"
        ></script>
        <script src="dist/assets/js/glider.min.js"></script>
        <script src="dist/assets/js/app.js"></script>
    </body>
</html>