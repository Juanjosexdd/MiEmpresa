<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Product;
use App\Models\Setting;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function create_cart()
    {
    	/*
			Comparamos si no existe sesión o si existen productos en el carrito, 
            creamos el contenido de la variable y seteamos la sesion.
			De lo contrario calculamos los totales.
    	*/

        if(!session()->get('cart') || empty(session()->get('cart')['products']))
        {
            $cart = 
            [
                'cart' =>
                [
                    'products'     => [],
                    'subtotal'     => 0,
                    'total'        => 0,
                    'delivery'     => 0
                ]
            ];

            session($cart);
            return session()->get('cart');
        }

       
        $subtotal   = 0;
        $total      = 0;
        $delivery   = 0;

        foreach(session('cart')['products'] as $index => $product)
        {
            $_subtotal = ((int) $product['price'] * (int) $product['quantity']);
            $subtotal  = $subtotal + $_subtotal;
            session()->put('cart.products.' . $index , $product);
        }

        $total      = $subtotal;

        $cart = 
            [
                'cart' =>
                [
                    'products'     => session('cart')['products'],
                    'subtotal'     => $subtotal,
                    'total'        => $total,
                    'delivery'     => $delivery
                ]
            ];


        session($cart);
        return session()->get('cart');
    }


    /*
        Agregar un producto al carrito
    */
    public function add_productcart($id , $quantity)
    {
        $product        = Product::where('id' , $id)->first();

        if(!$product)
        {
            return false;
        }

        $new_product    =
        [
            'id'            => $product->id,
            'name'          => $product->name,
            'description'   => $product->description,
            'quantity'      => $quantity,
            'price'         => $product->price,
            'image'         => $product->image
        ];

        /*
            Si los productos del carrito están vacíos entonces lo agregamos
        */

        if( empty(session()->get('cart')['products']) )
        {
            session()->push('cart.products' , $new_product);
            return true;
        }

        /*
            Si no, al menos ya hay uno, entonces lo recorremos
        */
        foreach(session()->get('cart')['products'] as $index => $product)
        {
            /*
                Si el id del producto ingresado coincide con el id del producto del bucle, sumamos la cantidad,
                de lo contrario, asimilamos que es un producto nuevo y agregamos
            */
            if($id == $product['id']) 
            {
                $product['quantity'] = $product['quantity'] + $quantity;
                session()->put('cart.products.' . $index , $product);
                return true;
            }

        }

        session()->push('cart.products' , $new_product);
        return true;
    }



    /*
        Remover un producto del carrito
    */
    public function delete_productcart($id)
    {

        /*
            Validamos si existen productos en el carrito, si en caso hay, empezamos a recorrer entre los productos
        */
        if(!session()->get('cart') || empty(session()->get('cart')['products']))
        {
            return false;
        }


        foreach( session()->get('cart')['products'] as $index => $product)
        {
            /*
                Si el id del producto entrante coincide con el id del producto del ciclo
                eliminamos el registro
            */

            if($id == $product['id'])
            {
                session()->forget('cart.products.' . $index , $product);
                return true;
            }

        }
    }


    /*
        Actualizar la cantidad de un producto
    */
    public function update_quantity($id , $quantity)
    {
        if(empty(session()->get('cart')['products']))
        {
            return false;
        }

        foreach(session()->get('cart')['products'] as $index => $product)
        {
            if($id == $product['id'])
            {
                $product['quantity']    =  $quantity;
                session()->put('cart.products.' . $index , $product);
                return true;
            }
        }
    }


    /*
        Eliminar el carrito de compras
    */
    public function destroy_cart()
    {
        if(!session()->get('cart') || empty( session()->get('cart')['products']) )
        {
            return false;
        }

        session()->forget('cart');
        return true;
    }


    /*
        Obtener la cantidad de productos existentes
    */
    public function get_cantproductscart()
    {
        $quantity = 0;
        if(!session()->get('cart') || empty( session()->get('cart')['products']) )
        {
            $quantity = 0;
            return $quantity;
        }

        foreach( session()->get('cart')['products'] as $index => $product)
        {
            $quantity = $quantity + $product['quantity'];
        }

        return $quantity;
    }

    public function get_settings()
    {
        $settings = Setting::where('id' , 1)->first();
        return $settings;
    }

    public function ticket()
    {
        $data['cart'] = $this->create_cart();
        return view('admin.ticket' , $data);
    }


    public function pdf_ticket($date, $address, $name_client, $phone, $name_order)
    {
        $data['date']        = $date;
        $data['address']     = $address;
        $data['name_client'] = $name_client;
        $data['phone']       = $phone;

        $data['cart']        = $this->create_cart();
        $pdf = PDF::loadView('admin.ticket' , $data);
        $pdf->setPaper(array(30,0,175,420));
        $pdf->save('admin/orders/' . $name_order . '.pdf');
        return true;
    }

}
