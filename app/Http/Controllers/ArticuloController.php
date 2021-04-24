<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Http\Request;

class ArticuloController extends Controller
{
  
    public function index()
    {
        return Articulo::orderBy('id','Desc')->get();
    }

  //se adicionno Articulo $articulo
    public function store(Request $request, Articulo $articulo)
    {

        $request->validate([
            'nombre'=>'required|min:4|max:150',
            'descripcion'=>'required|min:4',
            'stock'=>'required',
        ]);
        $articulo= new Articulo;
        $articulo->create($request->all());
    }

   
    public function show(Articulo $articulo)
    {
        return $articulo;
    }

  
    public function update(Request $request, Articulo $articulo)
    {
        $articulo->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Articulo $articulo)
    {
        $articulo->delete();
    }
}
