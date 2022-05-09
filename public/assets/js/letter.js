var path = $('meta[name="path"]').attr('content'),
    csrf = $('meta[name="csrf"]').attr('content');
    

/**
    * Agregando un producto al carrito 
    */
 $('body').on('click' , '.btnadd_product' , function(e){
    e.preventDefault();
     let id       = $(this).data('id'),
         quantity = parseInt($(this).data('quantity'));
    
    $.ajax({
        url      : path + '/addproductcart',
        method   : 'POST',
        data     : {
            '_token'  : csrf,
            id      : id,
            quantity: quantity
        },
        success  : function(r){
            if(!r.status) {
                alertify.set('notifier' , 'position', 'top-center');
                alertify.error(r.msg , '1.5');
                return;
            }

            alertify.set('notifier' , 'position', 'top-center');
            alertify.success(r.msg , '1.5');
            load_quantity();
        },
        dataType : 'json'
    });
});