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
            About the fit | An ecommerce app made with PHP and vanilla JS
        </title>
    </head>

    <body id="bodyJsPointer">
        <!-- Notification -->
        @include('components.notification')

        <!-- Overlay -->
        <div id="overlay"></div>

        <!-- Navigation bar -->
        @include('sections.navbar')

        <!-- Header -->
        @include('sections.header')

        <!-- Special offers -->
        @include('sections.offers')

        <!-- Instagram banner -->
        @include('sections.banner')

        <!-- Best Sellers and New pieces -->
        @include('sections.best_sellers')

        <!-- Blog -->
        @include('sections.blog')

        <!-- Newsletter -->
        @include('sections.newsletter')

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