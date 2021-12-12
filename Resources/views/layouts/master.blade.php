<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ __('openfoodfactssearchproducts::messages.openfoodfacts_search_products') }}">

    <title>{{ __('openfoodfactssearchproducts::messages.openfoodfacts_search_products') }}</title>

    <link rel="stylesheet" href="{{ mix('css/openfoodfactssearchproducts.css') }}">
</head>
<body>
<header>
    {{--Please use your header and footer.--}}
    <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a href="/openfoodfactssearchproducts" class="navbar-brand d-flex align-items-center">
                <strong>{{ __('openfoodfactssearchproducts::messages.openfoodfacts_search_products') }}</strong>
            </a>
        </div>
    </div>
</header>
<main>
    @include('openfoodfactssearchproducts::layouts.notifications')
    @yield('content')
</main>

<footer class="text-muted py-5">
    <div class="container">
        {{--Please use your header and footer.--}}
    </div>
</footer>

<script src="{{ mix('js/openfoodfactssearchproducts.js') }}"></script>

</body>
</html>
