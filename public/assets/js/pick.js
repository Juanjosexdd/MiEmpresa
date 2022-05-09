var path 	= $('meta[name="path"]').attr('content'),
    csrf    = $('meta[name="csrf"]').attr('content');

    //var myModal = new bootstrap.Modal(document.getElementById('modal_pick'));
    //myModal.show();
    
    $('body').on('click' , '.btn_pick' , function(e) {
        e.preventDefault();
        $('#modal_pick').modal('show');
    });


    $('body').on('click' , '.btn_validname', function(e) {
        e.preventDefault();
        let name   = $('input[name="name"]').val(),
            phone  = $('input[name="phone"]').val(),
            html   = '';

            $.ajax({
                url      : path + '/validname',
                method   : 'POST',
                data     : {
                    '_token' : csrf,
                    name   : name,
                    phone  : phone
                },
                success  : function(r){
                    if(!r.status) {
                        alertify.set('notifier' , 'position', 'top-center');
                        alertify.error(r.message , '1.5');
                        return;
                    }

                    $('#modal_pick .modal-title').html('Para terminar');
                    html = `<h6>Resumen del pedido</h6>
                    <table class="table">`;
                    $.each(r.cart.products , function(index, product) {
                        html += `<tr>
                                    <td class="border-top-0" style="padding: 0.5rem;">x${product.quantity} &nbsp; ${product.name} <span class="float-end">$/${(parseFloat(product.price * product.quantity).toFixed(2))}</span></td>
                                </tr>`;
                    });
                        
                    html += `<tr>
                            <td>
                                <h6 class="d-inline">COSTO TOTAL</h6> <span class="float-end fw-bold">$/<span class="pay_total">${parseFloat(r.cart.total).toFixed(2)}</span></span>
                            </td>
                        </tr>
                    </table>

                    <form>
                        <div class="form-group row">
                            <label for="way_pay" class="col-sm-4 col-form-label">Forma de pago</label>
                            <div class="col-sm-5 offset-md-3" id="way_pay">
                                <select class="form-select way_pay" name="way_pay">
                                    <option selected>[SELECCIONE]</option>
                                    <option value="1">Efectivo</option>
                                    <option value="2">Yape</option>
                                    <option value="3">Plin</option>
                                    <option value="4">Transferencia</option>
                                </select>
                            </div>
                        </div>

                        <div id="wrapper_balance" class="form-group row d-none">
                            <label for="balance" class="col-sm-4 col-form-label col-form-label-sm">¿Con cuánto pagará? $/.</label>
                            <div class="col-sm-5 offset-md-3">
                                <div class="form-group">
                                    <input type="text" class="form-control input_balance" id="balance" aria-describedby="balance" required>
                                    <div class=""><small class="fw-bold mt-1 invalid_balance"></small></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="comment">Comentarios adicionales</label>
                            <textarea class="form-control comment" name="comment" id="comment" cols="6" rows="2" placeholder="(Opcional)"></textarea>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-block btn-success btn_sendorder" disabled>
                                <i class="lni lni-whatsapp"></i> Click aquí para enviar tu pedido
                            </button>
                        </div>
                    </form>`;
                    
                    $('#wrapper_picks').html(html);
                },
                dataType : 'json'
            });
    });

    /**
     * Validar efectivo 
    */
    $('body').on('change', '.way_pay' , function() {
        let value = $(this).val();

            if(value == '2' || value == '3' || value == '4')
            {
                $('.btn_sendorder').prop('disabled' , false);
            }

            if(value == '1')
            {
                $('#wrapper_balance').removeClass('d-none');
            }

            else
            {
                $('#wrapper_balance').addClass('d-none');
            }
    });


    /**
    * Validar el balance (cambio) 
    */
    $('body').on('keyup' , '.input_balance', function() {
    $('.invalid_balance').removeClass('text-danger').removeClass('text-dark').html('');
    $('.btn_sendorder').prop('disabled' , true);

        let value     = parseInt($(this).val()),
        pay_total = parseInt($('.pay_total').text());

        if(isNaN(value))
        {
            return;
        }     

        if(value < pay_total)
        {
            $('.invalid_balance').addClass('text-danger').html(`El monto debe ser mayor a $/. ${parseFloat(pay_total).toFixed(2)} (Costo total)`);
            $('.btn_sendorder').prop('disabled' , true);
        }
        
        if(value > pay_total)
        {
            $('.invalid_balance').removeClass('text-danger').addClass('text-dark').html(`Su cambio es: ${parseFloat(value - pay_total).toFixed(2)}`);
            $('.btn_sendorder').prop('disabled' , false);
        }

        if(value == pay_total)
        {
            $('.btn_sendorder').prop('disabled' , false);
        }
    });


    /*
   * Enviar orden
   */            
   $('body').on('click' , '.btn_sendorder' , function(e) {
    e.preventDefault();
    let way_pay         = $('.way_pay').val(),
        input_balance   = $('.input_balance').val(),
        comment         = $('.comment').val(),
        html            = '';

        $.ajax({
            url      : path + '/sendorder',
            method   : 'POST',
            data     : {
                '_token'     : csrf,
                way_pay      : way_pay,
                input_balance: input_balance,
                comment      : comment
            },
            success  : function(r){
                if(!r.status) {
                    alertify.set('notifier' , 'position', 'top-center');
                    alertify.error(r.message , '1.5');
                    return;
                }
 
                html += `Hola! vengo de https://www.MiEmpresa.com` + '\n';
                html += `${r.date} \n`;
                html += `${r.hour} \n \n`;
                html += `Tipo de servicio: Recojo en local \n \n`;
                html += `Nombre: ${r.name} \n`;
                html += `Teléfono: ${r.phone} \n`;
                html += `Método de pago solicitado: ${r.way_pay_send} \n \n`;
                
                if(r.way_pay_send == 'Efectivo')
                {
                    html += `Costos \n`;
                    html += `Total a pagar: $/${r.pay_total} \n`;
                    html += `Efectivo: $/${r.balance} \n`;
                    html += `Cambio: $/${r.change} \n \n`;
                }

                else
                {
                    html += `Costos \n`;
                    html += `Total a pagar: $/${r.pay_total} \n \n`;
                }

                html += `Detalle del pedido \n`;
                $.each(r.products , function(index , product) {
                    html += `x${product.quantity} - ${product.name} $/${parseFloat((product.price * product.quantity)).toFixed(2)} \n`;
                });
                html += `\n\n`;
                html += `Envía este mensaje, te atenderemos en seguida.`;
                window.open(`https://api.whatsapp.com/send?phone=58${r.whatsapp}&text=${encodeURI(html)}`);
                destroycart();
            },

            dataType : 'json'
        });
    });


    function destroycart()
    {
        $.ajax({
            url      : path + '/destroycart',
            method   : 'POST',
            data     : {
                '_token' : csrf
            },
            success  : function(r){
                if(!r.status)
                {
                    alertify.set('notifier' , 'position', 'top-center');
                    alertify.error(r.message , '1.5');
                    return;
                }

                return window.location.href = path + '/letter';
            },
            dataType : 'json'
        });
    }

    