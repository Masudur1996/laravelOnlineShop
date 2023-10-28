@extends('front.layout.master')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-6 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 sidebar">
                    <div class="sub-title">
                        <h2>Categories</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionExample">
                                @if ($categories)
                                    @foreach ($categories as $key => $category)
                                        <div class="accordion-item">
                                            @if ($category->sub_categories->isNotEmpty())
                                                <h2 class="accordion-header" id="heading{{ $key }}">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse{{ $key }}" aria-expanded="false"
                                                        aria-controls="collapse{{ $key }}">
                                                        {{ $category->name }}
                                                    </button>
                                                </h2>
                                            @else
                                                <a class="nav-link nav-item {{ $categorySelected == $category->id ? 'text-primary' : '' }} "
                                                    href="{{ route('shop.home', $category->slug) }}">{{ $category->name }}</a>
                                            @endif

                                            @if ($category->sub_categories->isNotEmpty())
                                                <div id="collapse{{ $key }}"
                                                    class="accordion-collapse collapse {{ $categorySelected == $category->id ? 'show' : '' }}"
                                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample"
                                                    style="">
                                                    <div class="accordion-body">
                                                        <div class="navbar-nav">

                                                            @foreach ($category->sub_categories as $subCategory)
                                                                @if ($subCategory->status == 1 && $subCategory->showHome == 'Yes')
                                                                    <a href="{{ route('shop.home', [$category->slug, $subCategory->slug]) }}"
                                                                        class="nav-item nav-link {{ $subCategorySelected == $subCategory->id ? 'text-primary' : '' }}">{{ $subCategory->name }}</a>
                                                                @endif
                                                            @endforeach

                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Brand</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            @foreach ($brands as $brand)
                                <div class="form-check mb-2">
                                    <input {{ in_array($brand->id, $brandArray) ? 'checked' : '' }}
                                        class="form-check-input brandCheck" name="brands[]" type="checkbox"
                                        value="{{ $brand->id }}" id="flexCheckDefault{{ $brand->id }}">
                                    <label class="form-check-label" for="flexCheckDefault{{ $brand->id }}">
                                        {{ $brand->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                    </div>

                    <div class="sub-title mt-5">
                        <h2>Price</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <input type="text" class="js-range-slider" name="my_range" value="" />
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row pb-3">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <div class="ml-2">
                                    <div class="btn-group">
                                        <select name="sort" id="sort">
                                            <option value="">Sort</option>
                                            <option {{ $sort == 'latest' ? 'selected' : '' }} value="latest">Latest</option>
                                            <option {{ $sort == 'price_asc' ? 'selected' : '' }} value="price_asc">Price
                                                Low to High</option>
                                            <option {{ $sort == 'price_desc' ? 'selected' : '' }} value="price_desc">Price
                                                High to Low</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        @foreach ($products as $product)
                            <div class="col-md-4">
                                <div class="card product-card">
                                    <div class="product-image position-relative">

                                        @if ($product->product_images->isNotEmpty())
                                            @php
                                                $image = $product->product_images->first();
                                            @endphp
                                            <a href="{{route('front.product',$product->slug)}}" class="product-img"><img class="card-img-top"
                                                    src="{{ asset('uploads/images/product/small/' . $image->name) }}"
                                                    alt=""></a>
                                            <a class="whishlist" href="#"><i class="far fa-heart"></i></a>
                                        @else
                                            <a href="{{route('front.product',$product->slug)}}" class="product-img"><img class="card-img-top"
                                                    src="{{ asset('admin-asset/img/default-150x150.png') }}"
                                                    alt=""></a>
                                            <a class="whishlist" href="#"><i class="far fa-heart"></i></a>
                                        @endif

                                        <div class="product-action">
                                            <a class="btn btn-dark" href="#">
                                                <i class="fa fa-shopping-cart"></i> Add To Cart
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body text-center mt-3">
                                        <a class="h6 link" href="product.php">{{ $product->name }}</a>
                                        <div class="price mt-2">
                                            <span class="h5"><strong>{{ $product->price }}</strong></span>
                                            <span class="h6 text-underline"><del>{{ $product->compare_price }}</del></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="col-md-12 pt-5">
                            <nav aria-label="Page navigation example">
                                {{$products->withQueryString()->links()}}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('customJs')
    <script>
        //for range slider
        $(".js-range-slider").ionRangeSlider({
            type: "double",
            min: 0,
            max: 40000,
            from: {{ $price_min }},
            step: 50,
            to: {{ $price_max }},
            skin: "round",
            max_postfix: "+",
            prefix: "$",
            onFinish: function() {
                applyFilter();
            }
        });

        //for getting data from range slider
        var slider = $(".js-range-slider").data("ionRangeSlider");

        $('.brandCheck').change(function() {
            //if brand check change then this method will call
            applyFilter()
        });

        $('#sort').change(function() {
            //if sort option change then this method will call
            applyFilter()
        });


        function applyFilter() {
            let brands = [];

            //when any brand is checked then the value of brand id will push in brands arry
            $('.brandCheck').each(function() {
                if ($(this).is(":checked") == true) {
                    brands.push($(this).val())
                }
            })

            let url = "{{ url()->current() }}?";

            url += '&price_min=' + slider.result.from + '&price_max=' + slider.result.to;
            if (brands.length > 0) {
                url += '&brand=' + brands.toString();
            }



            url += '&sort=' + $('#sort').val();


            window.location.href = url
        }
    </script>
@endsection
