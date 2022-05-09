@extends('plantilla')
@section('title', 'Carrito')
@section('content')
    <div class="shopping-cart section">
        <div id="test_position"></div>
        <div id="wrapper_cart" class="container"></div>
    </div>

    <!--  aria-labelledby="modal_pick"
                        aria-hidden="true"-->
    <!-- Recojo en local  -->
    <div class="modal fade review-modal" id="modal_pick" tabindex="-1" aria-labelledby="picks" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="picks">Sus datos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="wrapper_picks" class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <label>Su nombre</label>
                            <input type="text" name="name" id="name">
                        </div>

                        <div class="form-group">
                            <label>Su teléfono (+58)</label>
                            <input type="text" name="phone" id="phone">
                        </div>

                        <div class="form-group button">
                            <button type="submit" value="submit" id="submit" class="btn btn_validname"
                                name="submit">Validar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Delivery  -->
    <div class="modal fade review-modal" id="modal_delivery" tabindex="-1" aria-labelledby="delivery" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delivery">Sus datos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="wrapper_delivery" class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <label>Su nombre</label>
                            <input type="text" name="namedeli" id="namedeli">
                        </div>

                        <div class="form-group">
                            <label>Su teléfono (+58)</label>
                            <input type="text" name="phonedeli" id="phonedeli">
                        </div>

                        <div class="form-group button">
                            <button type="submit" value="submit" id="submit" class="btn btn_validnamedeli"
                                name="submit">Validar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--<div class="modal fade review-modal" id="modal_pruebita" tabindex="-1" aria-labelledby="pruebita" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pruebita">Sus datos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="wrapper_pruebita" class="modal-body">
                    <h6 class="text-center">Su dirección:</h6>

                    <div class="form-group mt-3">
                        <input type="email" class="form-control" disabled>
                    </div>

                    <div class="form-group mb-3">
                        <input type="email" class="form-control form-control-sm" placeholder="Información adicional (N° depto, casa)" disabled>
                    </div>

                    <label for="">Si no se encontró tu ubicación:</label>
                    <div class="form-floating">
                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Déjanos tu dirección exacta aquí</label>
                    </div>

                    <div class="form-group mt-3 text-center">
                        <button class="btn btn-primary">Confirmar</button>
                    </div>

                </div>
            </div>
        </div>
    </div> -->


@endsection
@section('scripts')
    <script src="{{ asset('assets/js/cart.js') }}"></script>
    <script src="{{ asset('assets/js/pick.js') }}"></script>
    <script src="{{ asset('assets/js/delivery.js') }}"></script>
@endsection
