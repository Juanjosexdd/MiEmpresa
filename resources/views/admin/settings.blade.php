@extends('admin.plantilla')
@section('title', 'Configuraciones')
@section('header_content')
    <h4 class="d-inline-block">Configuraciones</h4>
@endsection
@section('content')
    <form class="row" action="{{ route('admin.updatesett') }}" method="POST" enctype="multipart/form-data">
        @if (session('noty'))
            <script>
                alertify.set('notifier', 'position', 'top-center');
                alertify.success("{{ session('noty') }}", '2');
            </script>
        @endif
        @csrf
        <div class="col-md-4">
            <div class="form-group">
                <label for="name_company" class="col-form-label">Nombre de la empresa:</label>
                <input type="text" class="form-control" name="name_company" value="{{ $setting->name_company }}">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="address" class="col-form-label">Dirección:</label>
                <input type="text" id="address" class="form-control" name="address" value="{{ $setting->address }}">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="phone" class="col-form-label">Teléfono:</label>
                <input type="text" id="phone" class="form-control" name="phone" value="{{ $setting->phone }}">
            </div>
        </div>


        <div class="col-md-4">
            <div class="form-group">
                <label for="url_fb" class="col-form-label">URL Facebook:</label>
                <input type="text" id="url_fb" class="form-control" name="url_fb" value="{{ $setting->url_fb }}">
            </div>
        </div>

        
        <div class="col-md-4">
            <div class="form-group">
                <label for="url_insta" class="col-form-label">URL Instagram:</label>
                <input type="text" id="url_insta" class="form-control" name="url_insta" value="{{ $setting->url_insta }}">
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="form-group">
                <label for="url_maps" class="col-form-label">URL Maps:</label>
                <input type="text" id="url_maps" class="form-control" name="url_maps" value="{{ $setting->url_maps }}">
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="form-group">
                <label for="yape" class="col-form-label">Cedula:</label>
                <input type="text" id="yape" class="form-control" name="yape" value="{{ $setting->yape }}">
            </div>
        </div>


        <div class="col-md-4">
            <div class="form-group">
                <label for="plin" class="col-form-label">Banco:</label>
                <input type="text" id="plin" class="form-control" name="plin" value="{{ $setting->plin }}">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="transferencia" class="col-form-label">N° Cta Transferencia:</label>
                <input type="text" id="transferencia" class="form-control" name="transferencia" value="{{ $setting->transferencia }}">
            </div>
        </div>


        <div class="col-md-4">
            <div class="custom-file-container" data-upload-id="logo_home">
                <label>Logo Principal <small class="text-danger">(960x960 aprox)</small> <a href="javascript:void(0)" class="custom-file-container__image-clear"
                        title="Limpiar imagen">x</a></label>
                <a href="{{ asset('assets/images/settings/' . $setting->logo_home) }}" class="float-right text-warning bs-tooltip" title="Ver actual" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </a>
                <label class="custom-file-container__custom-file">
                    <input type="file" class="custom-file-container__custom-file__custom-file-input" accept="image/*" name="logo_home">
                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                    <span class="custom-file-container__custom-file__custom-file-control"></span>
                </label>
                <div class="custom-file-container__image-preview"></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="custom-file-container" data-upload-id="logo_shop">
                <label>Logo tienda <small class="text-danger">(200x42 aprox)</small> <a href="javascript:void(0)" class="custom-file-container__image-clear"
                        title="Limpiar imagen">x</a></label>
                <a href="{{ asset('assets/images/settings/' . $setting->logo_shop) }}" class="float-right text-warning bs-tooltip" title="Ver actual" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </a>
                <label class="custom-file-container__custom-file">
                    <input type="file" class="custom-file-container__custom-file__custom-file-input" accept="image/*" name="logo_shop">
                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                    <span class="custom-file-container__custom-file__custom-file-control"></span>
                </label>
                <div class="custom-file-container__image-preview"></div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="custom-file-container" data-upload-id="logo_footer">
                <label>
                    Logo footer <small class="text-danger">(200x42 aprox)</small> <a href="javascript:void(0)" class="custom-file-container__image-clear"
                        title="Limpiar imagen">x</a>
                </label>
                <a href="{{ asset('assets/images/settings/' . $setting->logo_footer) }}" class="float-right text-warning bs-tooltip" title="Ver actual" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </a>
                <label class="custom-file-container__custom-file">
                    <input type="file" class="custom-file-container__custom-file__custom-file-input" accept="image/*" name="logo_footer">
                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                    <span class="custom-file-container__custom-file__custom-file-control"></span>
                </label>
                <div class="custom-file-container__image-preview"></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <button class="btn btn-primary">Guardar</button>
                <a href="{{ route('admin.home') }}" class="btn btn-danger">Volver</a>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        var logo_home   = new FileUploadWithPreview('logo_home'),
            logo_shop   = new FileUploadWithPreview('logo_shop'),
            logo_footer = new FileUploadWithPreview('logo_footer');
    </script>
@endsection
