<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Order;
use App\Models\DetailOrder;

class CartController extends Controller
{
    public function index()
    {
        return view('cart');
    }

    public function getcart(Request $request)
    {
        if (!$request->ajax()) {
            echo json_encode(['status' => false, 'msg' => 'Algo pasó, intente de nuevo']);
            return;
        }

        $cart = $this->create_cart();
        $html = '';

        if (empty($cart['products'])) {
            $html .= '<div class="text-center"><i class="lni lni-shopping-basket" style="font-size: 130px;"></i><p class="text-muted">El carrito está vacío</p><a href="' . route("letter") . '" class="btn btn-primary mt-2 btn_paysale">Seguir comprando</a></div>';
        } else {
            $html .= '<div class="cart-list-head">
                        <div class="cart-list-title">
                            <div class="row">
                                <div class="col-lg-1 col-md-1 col-12">
                                </div>
                                <div class="col-lg-6 col-md-3 col-12">
                                    <p>Producto</p>
                                </div>
                                <div class="col-lg-2 col-md-2 col-12">
                                    <p>Cantidad</p>
                                </div>
                                <div class="col-lg-2 col-md-2 col-12">
                                    <p>Subtotal</p>
                                </div>
                                <div class="col-lg-1 col-md-2 col-12">
                                    <p>Eliminar</p>
                                </div>
                            </div>
                        </div>';

            foreach ($cart['products'] as $product) :
                $html .= '<div class="cart-single-list">
                                        <div class="row align-items-center">
                                            <div class="col-lg-1 col-md-1 col-12">
                                                <a href="" style="pointer-events: none;"><img src="' . asset("assets/images/products/" . $product['image']) . '" alt="#"></a>
                                            </div>
                                            <div class="col-lg-6 col-md-3 col-12">
                                                <h5 class="product-name"><a href="" style="pointer-events: none;">' . $product["name"] . '</a></h5>
                                                <p class="product-des">
                                                <span>'.$product["description"].'</span>
                                                </p>
                                            </div>
                                            <div class="col-lg-1 col-md-1 col-12">
                                                <input type="number" class="form-control text-center input_quantity" value="' . $product["quantity"] . '" style="height: 30px;" data-id="' . $product["id"] . '"> 
                                            </div>
                                            <div class="col-lg-2 col-md-2 offset-md-1 col-12">
                                                <p>$/' . number_format(($product["price"] * $product["quantity"]), 2, ".", " ") . '</p>
                                            </div>
                                            <div class="col-lg-1 col-md-2 col-12">
                                                <a class="remove-item btn_remove" data-id="' . $product["id"] . '" href="javascript:void(0)"><i class="lni lni-close"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
            endforeach;

            $html .= '<div class="row">
                    <div class="col-12">
                        <div class="total-amount">
                            <div class="row">
                                <div class="col-md-4 offset-md-8 col-12">
                                    <div class="right" style="padding: 20px; padding-top: 20px;">
                                        <ul>
                                            <li class="last" style="font-size: 16px; font-weight: bold;">Total<span>$/<span>' . number_format($cart['total'], 2, '.', ' ') . '</span></span></li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="col-md-8 offset-md-4 col-12 mt-5 content_btn">
                                    <div class="button">
                                        <a href="" class="btn d-inline btn_pick">PARA RECOGER</a>
                                        <a href="" class="btn d-inline btn_delivery">A DOMICILIO</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>';
        }

        echo json_encode(['status'  => true, 'cart' => $html]);
    }


    public function remove_product(Request $request)
    {
        if (!$request->ajax()) {
            echo json_encode(['status' => false, 'msg' => 'Algo pasó, intente de nuevo']);
            return;
        }

        $id = (int) $request->input('id');
        if (!$this->delete_productcart($id)) {
            echo json_encode(['status' => false, 'msg' => 'No se pudo eliminar']);
            return;
        }
        echo json_encode(['status' => true, 'msg' => 'Producto eliminado']);
    }


    public function quantityproducts(Request $request)
    {
        if (!$request->ajax()) {
            echo json_encode(['status' => false, 'msg' => 'Algo pasó, intente de nuevo']);
            return;
        }
        $quantity = $this->get_cantproductscart();
        echo json_encode(['status' => true, 'quantity' => $quantity]);
    }


    public function updatequantity(Request $request)
    {
        if (!$request->ajax()) {
            echo json_encode(['status' => false, 'msg' => 'Algo pasó, intente de nuevo']);
            return;
        }

        $id         = (int) $request->input('id');
        $quantity   = (int) $request->input('quantity');

        if (!$this->update_quantity($id, $quantity)) {
            echo json_encode(['status' => false, 'msg' => 'No se pudo actualizar']);
            return;
        }
        echo json_encode(['status' => true, 'msg' => 'Actualizado correctamente']);
    }


    public function validname(Request $request)
    {
        if (!$request->ajax()) {
            echo json_encode(['status' => false, 'msg' => 'Algo pasó, intente de nuevo']);
            return;
        }

        $name   = trim(ucwords($request->input('name')));
        $phone  = trim($request->input('phone'));

        if (strlen($name) < 8) {
            echo json_encode(['status' => false, 'message' => 'El nombre debe tener al menos 8 caracteres']);
            return;
        }

        if (strlen($phone) != 11 || !is_numeric($phone)) {
            echo json_encode(['status' => false, 'message' => 'El número no es válido']);
            return;
        }

        $data_client =
            [
                'name'  => $name,
                'phone' => $phone
            ];

        $request->session()->put('data_client', $data_client);
        $cart = $this->create_cart();
        echo json_encode(['status' => true, 'cart' => $cart]);
    }

    public function sendorder(Request $request)
    {
        if(!$request->ajax()) 
        {
            echo json_encode(['status' => false, 'msg' => 'Algo pasó, intente de nuevo']);
            return;
        }

        $cart           = $this->create_cart();
        $way_pay        = $request->input('way_pay');
        $way_pay_send   = '';
        $input_balance  = (int) $request->input('input_balance');
        $comment        = $request->input('comment');
        $total_pay      = $cart['total'];
        $message_change = '';
        $resumen_order  = '';

        switch ($way_pay) {
            case '1':
                $way_pay_send = 'Efectivo';
                break;

            case '2':
                $way_pay_send = 'Yape (950772205)';
                $change       = '';
                break;

            case '3':
                $way_pay_send = 'Plin (950772205)';
                $change       = '';

            case '4':
                $way_pay_send = 'Transferencia';
                $change       = '';
                break;
        }

        if ($way_pay == '1') {
            $change = intval($input_balance - $total_pay);
        }

        $date       = date('d/m/Y');
        $hour       = date('H:i:s a');
        $address    = 'Recojo en local';
        $name       = $request->session()->get('data_client')['name'];
        $phone      = $request->session()->get('data_client')['phone'];
        $cost_total = number_format($cart['total'], 2, '.', ' ');
        $delivery   = number_format(0, 2, '.', ' ');
        $pay_total  = number_format($cart['total'], 2, '.', ' ');
        $products   = $cart['products'];
        $ticket     = date('d-m-Y-H-i-s');
        $whatsapp   = Setting::where('id' , 1)->first()['phone'];

        /**
         * Guardamos en la base de datos el pedido 
        */
        $data_order = 
        [
            'client'    => $name,
            'address'   => $address,
            'phone'     => $phone,
            'way_pay'   => $way_pay_send,
            'total'     => $total_pay,
            'date'      => date('Y-m-d' , strtotime($date)),
            'ticket'    => $ticket . '.pdf',
            'status'    => 1
        ];
        Order::insert($data_order);
        $last_order = Order::latest('id')->first()->id;

        foreach($products as $product)
        {
            $data_detail = 
            [
                'order_id'  => $last_order,
                'product'   => $product['name'],
                'price'     => $product['price']
            ];

            DetailOrder::insert($data_detail);
        }

        /**
         *  Generamos el ticket 
        */
        $this->pdf_ticket(
            $date . ' ' . $hour, 
            $address, 
            $name, 
            $phone, 
            $ticket
        );

        echo json_encode([
            'status'        => true,
            'date'          => $date,
            'hour'          => $hour,
            'name'          => $name,
            'phone'         => $phone,
            'way_pay_send'  => $way_pay_send,
            'cost_total'    => $cost_total,
            'delivery'      => $delivery,
            'pay_total'     => $pay_total,
            'products'      => $products,
            'balance'       => $input_balance,
            'change'        => $change,
            'whatsapp'      => $whatsapp
        ]);
    }


    public function destroycart(Request $request)
    {
        if(!$request->ajax()) 
        {
            echo json_encode(['status' => false, 'msg' => 'Algo pasó, intente de nuevo']);
            return;
        }

        if(!$this->destroy_cart())
        {
            echo json_encode(['status' => false, 'msg' => 'No se pudo vaciar el carrito']);
            return;
        }
        echo json_encode(['status' => true]);
    }


    public function validnamedeli(Request $request)
    {
        if (!$request->ajax()) {
            echo json_encode(['status' => false, 'msg' => 'Algo pasó, intente de nuevo']);
            return;
        }

        $name   = trim(ucwords($request->input('name')));
        $phone  = trim($request->input('phone'));

        if (strlen($name) < 8) {
            echo json_encode(['status' => false, 'message' => 'El nombre debe tener al menos 8 caracteres']);
            return;
        }

        if (strlen($phone) != 11 || !is_numeric($phone)) {
            echo json_encode(['status' => false, 'message' => 'El número no es válido']);
            return;
        }

        $data_client =
        [
            'name'  => $name,
            'phone' => $phone
        ];

        $request->session()->put('data_clientdeli', $data_client);
        echo json_encode(['status' => true]);
    }


    public function validardireccion(Request $request)
    {
        if (!$request->ajax()) {
            echo json_encode(['status' => false, 'msg' => 'Algo pasó, intente de nuevo']);
            return;
        }

        $info_direccion     = trim(ucfirst($request->input('info_direccion')));
        $info_adicional     = trim(ucfirst($request->input('info_adicional')));
        $direccion_manual   = trim(ucwords($request->input('direccion_manual')));
        $direccion          = '';
        $referencia         = '';

        if(empty($info_direccion) && empty($info_adicional) && empty($direccion_manual))
        {
            echo json_encode(['status' => false, 'msg' => 'Debe completar al menos un campo']);
            return;
        }

        if(empty($direccion_manual))
        {
            $direccion .= $info_direccion;
            if(empty($info_adicional))
            {
                $referencia .= '-';
            }
            else
            {
                $referencia .= $info_adicional;
            }

            $direccion_cliente =
            [
                'direccion'  => $direccion,
                'referencia' => $referencia
            ];
        }

        if(empty($info_direccion))
        {
            $direccion .= $direccion_manual;

            $direccion_cliente =
            [
                'direccion'  => $direccion,
                'referencia' => '-'
            ];
        }

        $request->session()->put('direccion_cliente', $direccion_cliente);
        $cart               = $this->create_cart();
        $direccion_client   = $request->session()->get('direccion_cliente');
        echo json_encode([
            'status'            => true,
            'cart'              => $cart,
            'direccion_cliente' => $direccion_client
        ]);
    }


    public function sendorderdeli(Request $request)
    {
        if(!$request->ajax()) 
        {
            echo json_encode(['status' => false, 'msg' => 'Algo pasó, intente de nuevo']);
            return;
        }

        $cart           = $this->create_cart();
        $way_pay        = $request->input('way_pay');
        $way_pay_send   = '';
        $input_balance  = (int) $request->input('input_balance');
        $comment        = $request->input('comment');
        $total_pay      = $cart['total'];
        $message_change = '';
        $resumen_order  = '';
        

        switch ($way_pay) {
            case '1':
                $way_pay_send = 'Efectivo';
                break;

            case '2':
                $way_pay_send = 'Yape (950772205)';
                $change       = '';
                break;

            case '3':
                $way_pay_send = 'Plin (950772205)';
                $change       = '';

            case '4':
                $way_pay_send = 'Transferencia (N° Cuenta: 4557 8865 1485 6598)';
                $change       = '';
                break;
        }

        if ($way_pay == '1') {
            $change = intval($input_balance - $total_pay);
        }

        $date       = date('d/m/Y');
        $hour       = date('H:i:s a');
        $name       = $request->session()->get('data_clientdeli')['name'];
        $phone      = $request->session()->get('data_clientdeli')['phone'];
        $cost_total = number_format($cart['total'], 2, '.', ' ');
        $delivery   = number_format(0, 2, '.', ' ');
        $pay_total  = number_format($cart['total'], 2, '.', ' ');
        $products   = $cart['products'];
        $direccion  = $request->session()->get('direccion_cliente')['direccion'] . ' ' . '(referencia: '. $request->session()->get('direccion_cliente')['referencia'] .')';
        $ticket     = date('d-m-Y-H-i-s');
        $whatsapp   = Setting::where('id' , 1)->first()['phone'];

        /**
         * Guardamos en la base de datos el pedido 
        */
        $data_order = 
        [
            'client'    => $name,
            'address'   => $direccion,
            'phone'     => $phone,
            'way_pay'   => $way_pay_send,
            'total'     => $total_pay,
            'date'      => date('Y-m-d' , strtotime($date)),
            'ticket'    => $ticket . '.pdf',
            'status'    => 1
        ];
        Order::insert($data_order);
        $last_order = Order::latest('id')->first()->id;

        foreach($products as $product)
        {
            $data_detail = 
            [
                'order_id'  => $last_order,
                'product'   => $product['name'],
                'price'     => $product['price']
            ];

            DetailOrder::insert($data_detail);
        }

        /**
         * Generamos el ticket
        */

        $this->pdf_ticket(
            $date . ' ' . $hour, 
            $request->session()->get('direccion_cliente')['direccion'] . ' ' . '(referencia: '. $request->session()->get('direccion_cliente')['referencia'] .')', 
            $name, 
            $phone, 
            date('d-m-Y-H-i-s')
        );

        echo json_encode([
            'status'        => true,
            'date'          => $date,
            'hour'          => $hour,
            'name'          => $name,
            'phone'         => $phone,
            'way_pay_send'  => $way_pay_send,
            'cost_total'    => $cost_total,
            'delivery'      => $delivery,
            'pay_total'     => $pay_total,
            'products'      => $products,
            'balance'       => $input_balance,
            'change'        => $change,
            'direccion'     => $direccion,
            'whatsapp'      => $whatsapp
        ]);
    }
}
