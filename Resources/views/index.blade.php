@extends('openfoodfactssearchproducts::layouts.master')

@section('content')
    <section class="py-3 text-center container">
        <div class="row py-lg-3">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">{{ __('openfoodfactssearchproducts::messages.search_by_product_name') }}</h1>
                <form class="py-3 d-flex" action="{{ route('openfoodfactssearchproducts::search') }}" method="get">
                    <input class="form-control me-2" type="search" name="search_terms" placeholder="{{ __('openfoodfactssearchproducts::messages.enter_product_name') }}">
                    <button class="btn btn-primary" type="submit">{{ __('openfoodfactssearchproducts::messages.search') }}</button>
                </form>
            </div>
        </div>
    </section>

    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                @if(!empty($products) && count($products) >= 1)
                    @foreach($products as $product)
                        <div class="col">
                            <div class="card shadow-sm openfoodfactssearchproducts-card">
                                <div class="openfoodfactssearchproducts-card-img">
                                    @if(!empty($product->image_url))
                                        <img src="{{ $product->image_url }}" alt="{{ $product->product_name }}" class="rounded mx-auto d-block openfoodfactssearchproducts-img">
                                    @else
                                        <svg class="bd-placeholder-img card-img-top"
                                             width="100%"
                                             height="225"
                                             xmlns="http://www.w3.org/2000/svg"
                                             role="img"
                                             aria-label="{{ __('openfoodfactssearchproducts::messages.thumbnail') }}"
                                             preserveAspectRatio="xMidYMid slice"
                                             focusable="false">
                                            <title>{{ __('openfoodfactssearchproducts::messages.thumbnail') }}</title>
                                            <rect width="100%" height="100%" fill="#f8f9fa"/>
                                            <text x="50%" y="50%" fill="#000" dy=".3em">{{ __('openfoodfactssearchproducts::messages.thumbnail') }}</text></svg>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title openfoodfactssearchproducts-card-title">{{ $product->product_name }}</h5>
                                    <div class="card-text openfoodfactssearchproducts-card-text">
                                        @if(!empty($product->categories_tags) && count($product->categories_tags) >= 1)
                                            @foreach($product->categories_tags as $category_tag)
                                                <span class="badge bg-light text-dark">{{ $category_tag }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <form action="{{ route('openfoodfactssearchproducts::store') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $product->id }}">
                                                <input type="hidden" name="product_name" value="{{ $product->product_name }}">
                                                <input type="hidden" name="categories" value="{{ $product->categories }}">
                                                <input type="hidden" name="image_url" value="{{ $product->image_url }}">
                                                <button class="btn btn-primary" type="submit">{{ __('openfoodfactssearchproducts::messages.save') }}</button>
                                            </form>
                                        </div>
                                        <small class="text-muted">{{ $product->id }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-md-12 openfoodfactssearchproducts-pagination">
                        <div class="row">
                            {{$products->links()}}
                        </div>
                    </div>
                @else
                    <div class="card-body text-center">
                        <p>{{ __('openfoodfactssearchproducts::messages.no_products') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
