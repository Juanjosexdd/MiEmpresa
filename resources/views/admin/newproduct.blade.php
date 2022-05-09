@extends('admin.plantilla')
@section('title', 'Nuevo producto')
@section('header_content')
    <h4 class="d-inline-block">Nuevo producto</h4>
@endsection
@section('content')
    <form class="row" action="{{ route('admin.addnewproduct') }}" method="POST" enctype="multipart/form-data">
        @if (session('noty'))
            <script>
                alertify.set('notifier', 'position', 'top-center');
                alertify.error("{{ session('noty') }}", '2');
            </script>
        @endif
        @csrf
        <div class="col-md-4">
            <div class="form-group">
                <label for="" class="col-form-label">Nombre:</label>
                <input type="text" class="form-control" name="name">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="price" class="col-form-label">Precio:</label>
                <input type="text" id="price" class="form-control" name="price">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="description" class="col-form-label">Descripción:</label>
                <textarea name="description" id="description" class="form-control" cols="8" rows="3"></textarea>
            </div>
        </div>


        <div class="col-md-12">
            <div class="custom-file-container" data-upload-id="myFirstImage">
                <label>Imagen (.jpg, .jpeg, .png) <a href="javascript:void(0)" class="custom-file-container__image-clear"
                        title="Clear Image">x</a></label>
                <label class="custom-file-container__custom-file">
                    <input type="file" class="custom-file-container__custom-file__custom-file-input" accept="image/*" name="image">
                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                    <span class="custom-file-container__custom-file__custom-file-control"></span>
                </label>
                <div class="custom-file-container__image-preview"></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <button class="btn btn-primary">Guardar</button>
                <a href="{{ route('admin.products') }}" class="btn btn-danger">Volver</a>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        var firstUpload = new FileUploadWithPreview('myFirstImage')
    </script>
@endsection
