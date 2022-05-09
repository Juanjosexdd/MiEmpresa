<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Setting;
use App\Models\State;
use Barryvdh\DomPDF\Facade as PDF;
use Hamcrest\Core\Set;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.home');
    }

    public function products()
    {
        return view('admin.products');
    }

    public function getproducts(Request $request)
    {
        if(!$request->ajax())
        {
            echo json_encode(['status' => false , 'mensaje' => 'Intente de nuevo']);
            return;
        }

        $products = Product::get();
        return Datatables()
                        ->of($products)
                        ->addIndexColumn()
                        ->addColumn('image' , function($products){
                            $image = $products->image;
                            $img   = '<img src="'.url("assets/images/products/" . $image).'" width="40px">';
                            return $img;
                        })
                        ->addColumn('options' , function($products){
                            $id    = $products->id;
                            $btn        = '<a class="text-warning bs-tooltip" href="'.route("admin.editproduct" , $id).'" data-toggle="tooltip" title="Editar"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>';

                            return $btn;
                        })
                        ->addColumn('available' , function($products){
                            $id        = $products->id;
                            $available = $products->available;
                            $btn       = '';
                            if($available == '1')
                            {
                                $btn   .= '<input type="checkbox" class="align-middle check_available bs-tooltip" style="font-size: 18px" checked data-id="'.$id.'" data-checked="true" title="Deshabilitar producto">';
                            }
                            else
                            {
                                $btn   .= '<input type="checkbox" class="align-middle check_available bs-tooltip" style="font-size: 18px" data-id="'.$id.'" data-checked="false" title="Habilitar producto">';
                            }

                            return $btn;
                        })
                        ->rawColumns(['image' , 'options', 'available'])
                        ->make(true);
    }


    public function newproduct()
    {
        return view('admin.newproduct');
    }

    public function addnewproduct(Request $request)
    {
        $file       = $request->file('image');
        if(!$file)
        {
            return redirect()->route('admin.newproduct')->with('noty' , 'Debe seleccionar una imagen');
        }

        $image         = $file->getClientOriginalName();
        $extension     = $file->extension();
        $name          = empty(trim(ucfirst($request->input('name')))) ? '' : trim(ucfirst($request->input('name')));
        $description   = empty(trim(ucfirst($request->input('description')))) ? '' : trim(ucfirst($request->input('description')));
        $price         = trim($request->input('price'));
        $available     = 1;
        $status        = 1;

        $dataproduct   = 
        [
            'name'        => $name,
            'description' => $description,
            'available'   => $available,
            'price'       => $price,
            'image'       => $image,
            'status'      => $status
        ];
        Product::insert($dataproduct);
        $file->move(public_path('assets/images/products/') , $image);
        return redirect()->route('admin.products')->with('noty' , 'Registro insertado correctamente');
    }

    public function editproduct($id)
    {
        $data['product'] = Product::where('id' , $id)->first();
        return view('admin.editproduct' , $data);
    }

    public function storeproduct(Request $request)
    {
        $file          = $request->file('image');
        $id            = $request->input('id');
        $name          = empty(trim(ucfirst($request->input('name')))) ? '' : trim(ucfirst($request->input('name')));
        $description   = empty(trim(ucfirst($request->input('description')))) ? '' : trim(ucfirst($request->input('description')));
        $price         = trim($request->input('price'));
        $available     = 1;
        $status        = 1;

        if(!$file)
        {
            $dataproduct   = 
            [
                'name'        => $name,
                'description' => $description,
                'available'   => $available,
                'price'       => $price,
                'status'      => $status
            ];
        }

        else
        {
            $image         = $file->getClientOriginalName();
            $name_img_db   = Product::where('id' , $id)->first()['image']; 
            $dataproduct   = 
            [
                'name'        => $name,
                'description' => $description,
                'available'   => $available,
                'price'       => $price,
                'image'       => $image,
                'status'      => $status
            ];

            unlink(public_path('assets/images/products/' . $name_img_db));
            $file->move(public_path('assets/images/products/') , $image);
        }
        Product::where('id' , $id)->update($dataproduct);
        return redirect()->route('admin.products')->with('noty' , 'Registro actualizado con éxito');
    }


    public function updatecheck(Request $request)
    {
        if(!$request->ajax())
        {
            echo json_encode(['status' => false , 'mensaje' => 'Intente de nuevo']);
            return;
        }

        $id        = $request->input('id');
        $check     = $request->input('check');
        $available = 0;
        $message   = '';

        if($check == 'true')
        {
            $available = 0;
            $message   = 'Producto deshabilitado';
        }

        else
        {
            $available = 1;
            $message   = 'Producto habilitado';
        }

        Product::where('id' , $id)->update(['available' => $available]);
        $request->session()->flash('noty' , $message);
        echo json_encode(['status' => true]);
    }


    public function settings()
    {
        $data['setting']    = Setting::where('id' , 1)->first();
        return view('admin.settings' , $data);
    }

    public function updatesett(Request $request)
    {
        $id             = 1;
        $logo_home      = $request->file('logo_home');
        $logo_shop      = $request->file('logo_shop');
        $logo_footer    = $request->file('logo_footer');
        $phone          = empty(trim($request->input('phone'))) ? '-' : trim($request->input('phone'));
        $url_fb         = empty(trim($request->input('url_fb'))) ? '#' :  trim($request->input('url_fb'));
        $url_insta      = empty(trim($request->input('url_insta'))) ? '#' :  trim($request->input('url_insta'));
        $url_maps       = empty(trim($request->input('url_maps'))) ? '#' :  trim($request->input('url_maps'));
        $yape           = empty(trim($request->input('yape'))) ? '-' :  trim($request->input('yape'));
        $plin           = empty(trim($request->input('plin'))) ? '-' :  trim($request->input('plin'));
        $transferencia  = empty(trim($request->input('transferencia'))) ? '-' :  trim($request->input('transferencia'));
        $address        = empty(trim($request->input('address'))) ? '-' :  trim($request->input('address'));
        $name_company   = empty(trim(ucfirst($request->input('name_company')))) ? '-' : trim(ucfirst($request->input('name_company')));

        if($logo_home)
        {
            $name_logo_home     = $logo_home->getClientOriginalName();
            $name_logo_home_db  = Setting::where('id' , $id)->first()['logo_home']; 
            $data_settings      = 
            [
                'logo_home'     => $name_logo_home,
                'phone'         => $phone,
                'url_fb'        => $url_fb,
                'url_insta'     => $url_insta,
                'url_maps'      => $url_maps,
                'yape'          => $yape,
                'plin'          => $plin,
                'transferencia' => $transferencia,
                'address'       => $address,
                'name_company'  => $name_company
            ];

            unlink(public_path('assets/images/settings/' . $name_logo_home_db));
            $logo_home->move(public_path('assets/images/settings/') , $name_logo_home);
        }

        if($logo_shop)
        {
            $name_logo_shop     = $logo_shop->getClientOriginalName();
            $name_logo_shop_db  = Setting::where('id' , $id)->first()['logo_shop']; 
            $data_settings      = 
            [
                'logo_shop'     => $name_logo_shop,
                'phone'         => $phone,
                'url_fb'        => $url_fb,
                'url_insta'     => $url_insta,
                'url_maps'      => $url_maps,
                'yape'          => $yape,
                'plin'          => $plin,
                'transferencia' => $transferencia,
                'address'       => $address,
                'name_company'  => $name_company
            ];

            unlink(public_path('assets/images/settings/' . $name_logo_shop_db));
            $logo_shop->move(public_path('assets/images/settings/') , $name_logo_shop);
        }

        if($logo_footer)
        {
            $name_logo_footer     = $logo_footer->getClientOriginalName();
            $name_logo_footer_db  = Setting::where('id' , $id)->first()['logo_footer']; 
            $data_settings      = 
            [
                'logo_footer'   => $name_logo_footer,
                'phone'         => $phone,
                'url_fb'        => $url_fb,
                'url_insta'     => $url_insta,
                'url_maps'      => $url_maps,
                'yape'          => $yape,
                'plin'          => $plin,
                'transferencia' => $transferencia,
                'address'       => $address,
                'name_company'  => $name_company
            ];

            unlink(public_path('assets/images/settings/' . $name_logo_footer_db));
            $logo_footer->move(public_path('assets/images/settings/') , $name_logo_footer);
        }

        else
        {
            $data_settings      = 
            [
                'phone'         => $phone,
                'url_fb'        => $url_fb,
                'url_insta'     => $url_insta,
                'url_maps'      => $url_maps,
                'yape'          => $yape,
                'plin'          => $plin,
                'transferencia' => $transferencia,
                'address'       => $address,
                'name_company'  => $name_company
            ];
        }
        Setting::where('id' , $id)->update($data_settings);
        return redirect()->route('admin.settings')->with('noty' , 'Datos actualizados correctamente');
    }


    public function getorders(Request $request)
    {
        if(!$request->ajax())
        {
            echo json_encode(['status' => false , 'mensaje' => 'Intente de nuevo']);
            return;
        }

        $orders = Order::orderBy('id', 'desc')->get();
        return Datatables()
                        ->of($orders)
                        ->addIndexColumn()
                        ->addColumn('status' , function($orders){
                            $id        = $orders->id;
                            $status    = $orders->status;
                            $btn       = '';
                            if($status == '1')
                            {
                                $btn   .= '<span class="badge badge-classic badge-warning"> Pendiente </span>';
                            }

                            if($status == '2')
                            {
                                $btn   .= '<span class="badge badge-classic badge-danger"> Cancelado </span>';
                            }

                            if($status == '3')
                            {
                                $btn   .= '<span class="badge badge-classic badge-success"> Entregado </span>';
                            }

                            return $btn;
                        })
                        ->addColumn('ticket' , function($orders){
                            $ticket = $orders->ticket;
                            $ticket_pdf = '<a href="'.url("admin/orders/" . $ticket).'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></a>';
                            return $ticket_pdf;
                        })
                        ->addColumn('options' , function($orders){
                            $id    = $orders->id;
                            $btn        = '<a class="text-warning bs-tooltip btn_updatestatus" href="" data-toggle="tooltip" title="Actualizar estado" data-id="'.$id.'"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>';

                            return $btn;
                        })
                        ->rawColumns(['status', 'ticket' ,'options'])
                        ->make(true);
    }


    public function modalstatus(Request $request)
    {
        if(!$request->ajax())
        {
            echo json_encode(['status' => false , 'mensaje' => 'Intente de nuevo']);
            return;
        }

        $id = (int) $request->input('id');
        $status  = Order::where('id' , $id)->first()['status'];
        $idorder = Order::where('id' , $id)->first()['id'];
        $states  = State::get();
        echo json_encode([
            'status'    => true , 
            'status_db' => $status, 
            'states'    => $states,
            'id'        => $idorder
        ]);
    }


    public function updatestatus(Request $request)
    {
        if(!$request->ajax())
        {
            echo json_encode(['status' => false , 'mensaje' => 'Intente de nuevo']);
            return;
        }

        $status = $request->input('status');
        $id     = $request->input('id');
        
        Order::where('id' , $id)->update(['status' => $status]);
        $request->session()->flash('noty' , 'Estado actualizado');
        echo json_encode(['status' => true]);
    }


}
