var path 	= $('meta[name="path"]').attr('content'),
    csrf    = $('meta[name="csrf"]').attr('content');

function load_cart()
{
	$.ajax({
		url 		: path + '/getcart',
		method  	: 'POST',
        data        : {
            '_token' : csrf
        },
		success		: function(r) {
			if(!r.status) {
				alert(r.msg);
				return;
			}

			$('#wrapper_cart').html(r.cart);
		},
		dataType	: 'json'
	});

	return false;
}

load_cart();

/**
 * Eliminar productos del carrito
*/
$('body').on('click' , '.btn_remove' , function(e) {
    e.preventDefault();
    let id = $(this).data('id');

    $.ajax({
		url 		: path + '/remove_product',
		method  	: 'POST',
        data        : {
            '_token' : csrf,
            id       : id
        },
		success		: function(r) {
			if(!r.status) {
				alert(r.msg);
				return;
			}

            alertify.set('notifier' , 'position', 'top-center');
            alertify.success(r.msg , '1.5');
            load_quantity();
			load_cart();
		},
		dataType	: 'json'
    });
});


   /**
    * Actualizar cantidad
   */
	$('body').on('change' , '.input_quantity', function() {
		let quantity = parseInt($(this).val()),
			id 		 = parseInt($(this).data('id'));

			if(isNaN(quantity))
			{
				return;
			}

			if(quantity <= 0)
			{
				quantity = 1;
			}

			if(quantity > 10)
			{
				quantity = 10;
			}

			$(this).val(quantity);
			$.ajax({
				url 		: path + '/updatequantity',
				method  	: 'POST',
				data        : {
					'_token' : csrf,
					id  	 : id,
					quantity : quantity
				},
				success		: function(r) {
					if(!r.status) {
						alert(r.msg);
						return;
					}
		
					alertify.set('notifier' , 'position', 'top-center');
					alertify.success(r.msg , '1.5');
					load_quantity();
					load_cart();
				},
				dataType	: 'json'
			});
		
			return false;
	});



	function getLocation() {
		if (navigator.geolocation) 
		{
			navigator.geolocation.getCurrentPosition(function(position) {
				$.get( "http://maps.googleapis.com/maps/api/geocode/json?latlng="+ position.coords.latitude + "," + position.coords.longitude +"&sensor=false&key=AIzaSyA0Y_dOtFNS6n_D9sEPvM7ZHsq7lRyJNQU", function(data) {
                    console.log(data);
                })
			});
		} 
		else 
		{
		  	console.log("Geolocation is not supported by this browser.");
		}
	}

	function getMyLocation()
	{
		if(navigator.geolocation)
		{
			navigator.geolocation.getCurrentPosition(
				function(GeolocationPosition){
				let latitud  = GeolocationPosition.coords.latitude,
					longitud = GeolocationPosition.coords.longitude;
					
				$.get(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitud}&lon=${longitud}`, function(data) {
					//$('#test_position').html(data.display_name);
					//console.log(data.address);
					console.log(data.address.road + ', ' + data.address.state);
				});
			}, 
			function(err){
				//alert(err.message);
				console.log('No se dio permiso de ubicación...');
			}, 
			{
				enableHighAccuracy: true
			});
		}
		else
		{
			alert('Este navegador no acepta GEO');
		}
	}

	//getMyLocation();

	// https://www.openstreetmap.org/#map=10/-6.3221/-76.8040
	// https://nominatim.openstreetmap.org/search?format=json&q=
	// https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitud}&lon=${longitud}