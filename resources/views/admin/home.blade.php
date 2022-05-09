@extends('admin.plantilla')
    @section('title' , 'Inicio')
    @section('header_content')
        <h4 class="d-inline-block">Lista de pedidos</h4>
    @endsection
    @section('content')
    <div class="table-responsive">
        @if (session('noty'))
            <script>
                alertify.set('notifier', 'position', 'top-center');
                alertify.success("{{ session('noty') }}", '2');
            </script>
        @endif
        <table id="table_orders" class="table table-bordered mb-4">
            <thead class="text-center">
                <tr>
                    <th>Cliente</th>
                    <th>Forma de pago</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Ticket</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade register-modal" id="modal_status" tabindex="-1" role="dialog" aria-labelledby="modal_statusLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" id="modal_statusLabel">
              <h4 class="modal-title">Actualizar estado</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
            </div>
            <div class="modal-body">
              <form id="form_status" class="mt-0">
                @csrf
                <div id="wrapper_select" class="form-group"></div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary mt-2 mb-2 btn-block btn_status">Aceptar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    @endsection
    @section('scripts')
        <script>
            function cargar_tabla()
            {
                let datatable = $('#table_orders').DataTable({
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

                    "ajax":"{{ route('admin.getorders') }}",
                    "columns": [
                        /*{data : null, render: function (data, type, full, meta) {
                            return meta.row + 1;
                        }, className : 'text-center align-middle'},*/
                        { data          : "client" , className : 'text-center align-middle'},
                        { data          : "way_pay" , className : 'text-center align-middle'},
                        { data          : "date" , className : 'text-center align-middle'},
                        { data          : "status" , className : 'text-center align-middle'},
                        { data          : "ticket" , className : 'text-center align-middle'},
                        { data          : "options" , className : 'text-center align-middle'}
                    ]
                });

                $('#table_orders_paginate').addClass('float-right');
                $('#table_orders').parent().parent().addClass('mt-3').addClass('mb-4');
                return datatable;
            }

            cargar_tabla();

        /*
        * Actualizar estado de orden
        */
        $('body').on('click' , '.btn_updatestatus', function(e) {
            e.preventDefault();
            let id   = $(this).data('id'),
                html = '';

            $.ajax({
                url      : "{{ route('admin.modalstatus') }}",
                method   : 'POST',
                data     : {
                    '_token' : "{{ csrf_token() }}",
                    id       : id
                },
                success  : function(r){
                    if(r.status)
                    {
                        html += `<select name="status" class="form-control">`;
                                $.each(r.states , function(index , state){
                                    if(state.id == r.status_db)
                                    {
                                        html += `<option value="${state.id}" selected>${state.description}</option>`;
                                        $('.btn_status').data('id' , r.id);
                                    }
                                    else
                                    {
                                        html += `<option value="${state.id}">${state.description}</option>`;
                                        $('.btn_status').data('id' , r.id);
                                    }
                                    
                                });
                                html += `</select>`;
                        
                        $('#wrapper_select').html(html);
                        $('#modal_status').modal('show');
                        return;
                    }
                },
                dataType : 'json'
            });
        });

        /*
        * 
        */
        $('body').on('click' , '.btn_status', function(e) {
            e.preventDefault();
            let status = $('select[name="status"]').val(),
                id   = $(this).data('id');
                $.ajax({
                    url      : "{{ route('admin.updatestatus') }}",
                    method   : 'POST',
                    data     : {
                        '_token'     : "{{ csrf_token() }}",
                        status : status,
                        id : id
                    },
                    success  : function(r){
                        if(!r.status)
                        {
                            alertify.set('notifier' , 'position', 'top-center');
                            alertify.error(r.message , '1.5');
                            return;
                        }

                        $('#modal_status').modal('hide');
                        window.location.href = "{{ route('admin.home') }}";
                    },
                    dataType : 'json' 
                });
        });

        </script>
    @endsection