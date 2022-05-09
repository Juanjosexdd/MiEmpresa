@extends('plantilla')
@section('title', 'Login')
@section('content')
    <div class="account-login section" style="padding-top: 10px; padding-bottom: 10px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" action="{{ route('login.logueo') }}" method="post">
                        @csrf
                        <div class="card-body">
                            @if(session('noty'))
                                <script>
                                    alertify.set('notifier' , 'position', 'top-center');
                                    alertify.error("{{ session('noty') }}" , '2');
                                </script>
                            @endif
                            <div class="title">
                                <h3>Iniciar sesión</h3>
                            </div>
                         
                            <div class="form-group input-group">
                                <label for="name">Usuario</label>
                                <input class="form-control form-control-sm" type="text" id="name" name="name">
                            </div>
                            <div class="form-group input-group">
                                <label for="password">Contraseña</label>
                                <input class="form-control form-control-sm" type="password" id="password" name="password">
                            </div>
                            
                            <div class="button">
                                <button class="btn" type="submit">Aceptar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
