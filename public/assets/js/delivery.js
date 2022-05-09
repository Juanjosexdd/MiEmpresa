var path = $('meta[name="path"]').attr("content"),
    csrf = $('meta[name="csrf"]').attr("content");

$("body").on("click", ".btn_delivery", function (e) {
    e.preventDefault();
    $("#modal_delivery").modal("show");
});

//var myModal = new bootstrap.Modal(document.getElementById('modal_pruebita'));
//myModal.show();

$("body").on("click", ".btn_validnamedeli", function (e) {
    e.preventDefault();
    let name = $('input[name="namedeli"]').val(),
        phone = $('input[name="phonedeli"]').val(),
        html = "";

    $.ajax({
        url: path + "/validnamedeli",
        method: "POST",
        data: {
            _token: csrf,
            name: name,
            phone: phone,
        },
        success: function (r) {
            if (!r.status) {
                alertify.set("notifier", "position", "top-center");
                alertify.error(r.message, "1.5");
                return;
            }

            $("#modal_delivery .modal-title").html("Tu ubicación");

            if (navigator.geolocation) {
                html += `<h6 class="text-center">Su dirección:</h6>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control info_direccion" disabled name="info_direccion">
                        </div>

                        <div class="form-group mb-3">
                            <input type="text" class="form-control form-control-sm info_adicional" placeholder="Información adicional (N° depto, casa)" disabled name="info_adicional">
                        </div>

                        <label id="label_ubicacion" for="">Si no se encontró tu ubicación:</label>
                        <div class="form-floating">
                            <input type="email" class="form-control direccion_manual" id="input_direccion_manual" name="direccion_manual" placeholder="name@example.com">
                            <label for="input_direccion_manual">Déjanos tu dirección exacta aquí</label>
                        </div>

                        <div class="form-group mt-3 text-center">
                            <button class="btn btn-primary btn_confirmardireccion">Confirmar</button>
                        </div>`;

                navigator.geolocation.getCurrentPosition(
                    function (GeolocationPosition) {
                        let latitud = GeolocationPosition.coords.latitude,
                            longitud = GeolocationPosition.coords.longitude;

                        $.get(
                            `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitud}&lon=${longitud}`,
                            function (data) {
                                if(data.address.road == undefined)
                                {
                                    $('#label_ubicacion').text('No pudimos encontrar tu ubicación, por favor escribe correctamente tu dirección').addClass('text-danger');
                                    $(".direccion_manual").focus();
                                }
                                
                                else
                                {
                                    $(".info_direccion").val(
                                        data.address.road +
                                            ", " +
                                            data.address.state
                                    );
                                    $(".info_adicional").prop("disabled", false);
                                    $(".direccion_manual").prop("disabled" , true);
                                }
                            }
                        );
                    },
                    function (err) {
                        $(".direccion_manual").focus();
                    },
                    {
                        enableHighAccuracy: true,
                    }
                );

                $("#wrapper_delivery").html(html);
            } else {
                alert(
                    "Este navegador no acepta GeoLocalización, pruebe con otro!"
                );
            }
        },
        dataType: "json",
    });
});

$("body").on("click", ".btn_confirmardireccion", function (e) {
    e.preventDefault();
    let info_direccion = $(".info_direccion").val(),
        info_adicional = $(".info_adicional").val(),
        direccion_manual = $(".direccion_manual").val(),
        html = "";

    $.ajax({
        url: path + "/validardireccion",
        method: "POST",
        data: {
            _token: csrf,
            info_direccion: info_direccion,
            info_adicional: info_adicional,
            direccion_manual: direccion_manual,
        },
        success: function (r) {
            if (!r.status) {
                alertify.set("notifier", "position", "top-center");
                alertify.error(r.msg, "1.5");
                return;
            }

            $("#modal_delivery .modal-title").html("Para terminar");
            html = `
                    <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="lni lni-map-marker"></i></span>
                    <input type="text" class="form-control" placeholder="${r.direccion_cliente.direccion} (Referencia: ${r.direccion_cliente.referencia})" aria-label="Username" aria-describedby="basic-addon1" disabled>
                    </div>
                    <h6>Resumen del pedido</h6>
                    <table class="table">`;
            $.each(r.cart.products, function (index, product) {
                html += `<tr>
                                    <td class="border-top-0" style="padding: 0.5rem;">x${
                                        product.quantity
                                    } &nbsp; ${
                    product.name
                } <span class="float-end">$/${parseFloat(
                    product.price * product.quantity
                ).toFixed(2)}</span></td>
                                </tr>`;
            });

            html += `<tr>
                            <td>
                                <h6 class="d-inline">COSTO TOTAL</h6> <span class="float-end fw-bold">$/<span class="pay_total">${parseFloat(
                                    r.cart.total
                                ).toFixed(2)}</span></span>
                            </td>
                        </tr>
                    </table>

                    <form>
                        <div class="form-group row">
                            <label for="way_paydeli" class="col-sm-4 col-form-label">Forma de pago</label>
                            <div class="col-sm-5 offset-md-3" id="way_paydeli">
                                <select class="form-select way_paydeli" name="way_paydeli">
                                    <option selected>[SELECCIONE]</option>
                                    <option value="1">Efectivo</option>
                                    
                                    <option value="4">Transferencia</option>
                                </select>
                            </div>
                        </div>

                        <div id="wrapper_balancedeli" class="form-group row d-none">
                            <label for="balance" class="col-sm-4 col-form-label col-form-label-sm">¿Con cuánto pagará? $/.</label>
                            <div class="col-sm-5 offset-md-3">
                                <div class="form-group">
                                    <input type="text" class="form-control input_balancedeli" id="balance" aria-describedby="balance" required>
                                    <div class=""><small class="fw-bold mt-1 invalid_balance"></small></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="commentdeli">Comentarios adicionales</label>
                            <textarea class="form-control commentdeli" name="commentdeli" id="commentdeli" cols="6" rows="2" placeholder="(Opcional)"></textarea>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-block btn-success btn_sendorderdeli" disabled>
                                <i class="lni lni-whatsapp"></i> Click aquí para enviar tu pedido
                            </button>
                        </div>
                    </form>`;

            $("#wrapper_delivery").html(html);
        },
        dataType: "json",
    });
});

/**
 * Validar efectivo
 */
$("body").on("change", ".way_paydeli", function () {
    let value = $(this).val();

    if (value == "2" || value == "3" || value == "4") {
        $(".btn_sendorderdeli").prop("disabled", false);
    }

    if (value == "1") {
        $("#wrapper_balancedeli").removeClass("d-none");
    } else {
        $("#wrapper_balancedeli").addClass("d-none");
    }
});

/**
 * Validar el balance (cambio)
 */
$("body").on("keyup", ".input_balancedeli", function () {
    $(".invalid_balance")
        .removeClass("text-danger")
        .removeClass("text-dark")
        .html("");
    $(".btn_sendorderdeli").prop("disabled", true);

    let value = parseInt($(this).val()),
        pay_total = parseInt($(".pay_total").text());

    if (isNaN(value)) {
        return;
    }

    if (value < pay_total) {
        $(".invalid_balance")
            .addClass("text-danger")
            .html(
                `El monto debe ser mayor a $/. ${parseFloat(pay_total).toFixed(
                    2
                )} (Costo total)`
            );
        $(".btn_sendorderdeli").prop("disabled", true);
    }

    if (value > pay_total) {
        $(".invalid_balance")
            .removeClass("text-danger")
            .addClass("text-dark")
            .html(`Su cambio es: ${parseFloat(value - pay_total).toFixed(2)}`);
        $(".btn_sendorderdeli").prop("disabled", false);
    }

    if (value == pay_total) {
        $(".btn_sendorderdeli").prop("disabled", false);
    }
});

/*
 * Enviar orden
 */
$("body").on("click", ".btn_sendorderdeli", function (e) {
    e.preventDefault();
    let way_pay         = $(".way_paydeli").val(),
        input_balance   = $(".input_balancedeli").val(),
        comment         = $(".commentdeli").val(),
        html            = "";

    $.ajax({
        url: path + "/sendorderdeli",
        method: "POST",
        data: {
            _token  : csrf,
            way_pay : way_pay,
            input_balance: input_balance,
            comment: comment,
        },
        success: function (r) {
            if (!r.status) {
                alertify.set("notifier", "position", "top-center");
                alertify.error(r.message, "1.5");
                return;
            }

            html += `Hola! vengo de https://www.MiEmpresa.com` + "\n";
            html += `${r.date} \n`;
            html += `${r.hour} \n \n`;
            html += `Tipo de servicio: A domicilio \n \n`;
            html += `Nombre: ${r.name} \n`;
            html += `Teléfono: ${r.phone} \n`;
            html += `Dirección: ${r.direccion} \n`;
            html += `Método de pago solicitado: ${r.way_pay_send} \n \n`;

            if (r.way_pay_send == "Efectivo") {
                html += `Costos \n`;
                html += `Total a pagar: $/${r.pay_total} \n`;
                html += `Efectivo: $/${r.balance} \n`;
                html += `Cambio: $/${r.change} \n \n`;
            } else {
                html += `Costos \n`;
                html += `Total a pagar: $/${r.pay_total} \n \n`;
            }

            html += `Detalle del pedido \n`;
            $.each(r.products, function (index, product) {
                html += `x${product.quantity} - ${product.name} $/${parseFloat(
                    product.price * product.quantity
                ).toFixed(2)} \n`;
            });
            html += `\n\n`;
            html += `Envía este mensaje, te atenderemos en seguida.`;
            window.open(
                `https://api.whatsapp.com/send?phone=58${r.whatsapp}&text=${encodeURI(
                    html
                )}`
            );
            destroycart();
        },

        dataType: "json",
    });
});
