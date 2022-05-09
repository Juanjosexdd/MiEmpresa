<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class LetterController extends Controller
{
    public function index()
    {
        $data['products']   = Product::get();
        return view('letter' , $data);
    }

    public function addproductcart(Request $request)
    {
        if(!$request->ajax())
    	{
    		echo json_encode(['status' => false, 'msg' => 'Algo pasó, intente de nuevo']);
    		return;
    	}

    	$id 		    = $request->input('id');
    	$quantity 	    = $request->input('quantity');

    	$add_product    = $this->add_productcart($id , $quantity);
    	if(!$add_product)
    	{
    		echo json_encode(['status' => false, 'msg' => 'No se pudo agregar el producto']);
    		return;
    	}

    	echo json_encode(['status' => true, 'msg' => 'Agregado correctamente']);
    }
}
