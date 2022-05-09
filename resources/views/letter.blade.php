@extends('plantilla')
@section('title' , 'Productos')
@section('content')
    <section class="trending-product section" style="padding-top: 20px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Bienvenido</h2>
                        <!--  <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                            suffered alteration in some form.</p>
                        <span class="sale-tag">No disponible ahora</span>-->
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach($products as $k => $product)
                    <div class="col-lg-2 col-md-6 col-12">
                        <div class="single-product">
                            <div class="product-image">
                                <img src="{{ asset('assets/images/products') . '/' . $product->image }}" alt="{{ $product->name }}">
                                @if($product->available == '0')
                                <span class="sale-tag">No disponible ahora</span>
                                @endif
                                @if($product->available == '1')
                                    <div class="button">
                                        <a class="btn btnadd_product" data-id="{{ $product->id }}" data-quantity="1"><i class="lni lni-cart"></i>
                                            Agregar</a>
                                    </div>
                                @else
                                    <div class="button" style="pointer-events: none; opacity: 0.5; backgroud: #ccc">
                                        <a class="btn btnadd_product" data-id="{{ $product->id }}" data-quantity="1"><i class="lni lni-cart"></i>
                                            Agregar</a>
                                    </div>
                                @endif
                            </div>
                            <div class="product-info">
                                <span class="category text-truncate">{{ $product->description }}</span>
                                <h4 class="title">
                                    <a href="" style="pointer-events: none;">{{ $product->name }}</a>
                                </h4>
                                <div class="price">
                                    <span>$/{{ number_format($product->price , 2, '.', ' ') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        </div>
    </section>

    

    <section class="shipping-info" style="padding-top: 10px; padding-bottom: 50px;">
        <div class="container">
            <ul class="d-md-flex flex-row justify-content-center alig-items-center">
                <li>
                    <div class="media-icon">
                        <i class="lni lni-delivery"></i>
                    </div>
                    <div class="media-body">
                        <h5>Delivery gratis</h5>
                    </div>
                </li>

                <li>
                    <div class="media-icon">
                        <i class="lni lni-credit-cards"></i>
                    </div>
                    <div class="media-body">
                        <h5>Pago seguro</h5>
                    </div>
                </li>
            </ul>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/letter.js') }}"></script>
@endsection