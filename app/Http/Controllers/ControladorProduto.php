<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;

class ControladorProduto extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView()
    {
        return view('produtos');
    }

    public function index()
    {
        $prods = Produto::all();
        return $prods->toJson(); //ou json_encode($prods) é a mesma coisa
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $prod = new Produto();
        $prod->nome = $request->nome;
        $prod->preco = $request->preco;
        $prod->stock = $request->stock;
        $prod->categoria_id = $request->categoria_id;
        $prod->save();

        return json_encode($prod);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $prod = Produto::find($id);
      if (isset($prod)) {
        return json_encode($prod);
      }
      return response('Produto nao encontrado!', 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $prod = Produto::find($id);
      if (isset($prod)) {
        $prod->nome = $request->nome;  //ter assim ou ter $request->input('nome') é igual
        $prod->preco = $request->preco;
        $prod->stock = $request->stock;
        $prod->categoria_id = $request->categoria_id;
        $prod->save();
        return json_encode($prod);
      }
      return response('Produto nao encontrado!', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $prod = Produto::find($id);
      if(isset($prod)) {
        $prod->delete();
        return response('ok', 200);
      }
      return response('Produto nao encontrado', 404); //funciona bem sem esta parte e sem o return response('ok',200)
    }
}
