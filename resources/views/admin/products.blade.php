@extends('admin.plantilla')
    @section('title' , 'Productos')
    @section('header_content')
        <h4 class="d-inline-block">Lista de productos</h4>
        <a href="{{ route('admin.newproduct') }}" class="btn btn-primary my-2 float-right">Nuevo</a>
    @endsection
    @section('content')
    <div class="table-responsive">
        @if (session('noty'))
            <script>
                alertify.set('notifier', 'position', 'top-center');
                alertify.success("{{ session('noty') }}", '2');
            </script>
        @endif
        <table id="table_products" class="table table-bordered mb-4">
            <thead class="text-center">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Opción</th>
                    <th>Disponible</th>
                </tr>
            </thead>
        </table>
    </div>
    @endsection
    @section('scripts')
        <script>
            function cargar_tabla()
            {
                let datatable = $('#table_products').DataTable({
                    fixedHeader     : true,
                    processing      : true,
                    serverSide      : true,
                    "paging"        : true,
                    "searching"     : true,
                    "destroy"       : true,
                    responsive      : true,
                    ordering        : false,
                    "lengthMenu"    : [[4, 15, 30, -1], [4, 15, 30, 200]],
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
                        "infoEmpty": "Mostrando 0 de 0 Registros",
                        "infoFiltered": "(Filtrado de _MAX_ total registros)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ Registros",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },

                    "ajax":"{{ route('admin.getproducts') }}",
                    "columns": [
                        /*{data : null, render: function (data, type, full, meta) {
                            return meta.row + 1;
                        }, className : 'text-center align-middle'},*/
                        { data          : "name" , className : 'text-center align-middle'},
                        { data          : "description" , className : 'text-center align-middle'},
                        {
                            data        : "price" , render : function(data){
                                return 'S/' + parseFloat(data).toFixed(2);
                            },
                            className   : 'text-center align-middle'
                        },
                        { data          : "image" , className : 'text-center align-middle'},
                        { data          : "options" , className : 'text-center align-middle'},
                        { data          : "available" , className : 'text-center align-middle'}
                    ]
                });

                $('#table_products_paginate').addClass('float-right');
                $('#table_products').parent().parent().addClass('mt-3').addClass('mb-4');
                return datatable;
            }

            cargar_tabla();


            /*
                Actualizar disponibilidad de productos
            */
           $('body').on('click', '.check_available', function(e) {
               e.preventDefault();
               let id     = $(this).data('id'),
                    check = $(this).data('checked');
                
                    $.ajax({
                        url     : "{{ route('admin.updatecheck') }}",
                        method  : 'POST',
                        data    : {
                            '_token' : "{{ csrf_token() }}",
                            id       : id,
                            check    : check
                        },
                        success : function(r){
                            if(!r.status)
                            {
                                alertify.set('notifier', 'position', 'top-center');
                                alertify.error("{{ session('noty') }}", '2');
                                return;
                            }

                            window.location.href = "{{ route('admin.products') }}";
                        },
                        dataType: 'json'
                    });
           });

        </script>
    @endsection