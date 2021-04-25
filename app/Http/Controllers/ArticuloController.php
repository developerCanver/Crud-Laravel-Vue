<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Http\Request;
use App\Http\Requests\ArticuloRequest;
class ArticuloController extends Controller
{
  
    public function index(Request $request)
    {
        $per_page=$request->per_page;
        return Articulo::orderBy('id','Desc')->paginate($per_page);
    }

  //se adicionno Articulo $articulo
    public function store(ArticuloRequest $request, Articulo $articulo)
    {

     
        $articulo= new Articulo;
        $articulo->create($request->all());
    }

   
    public function show(Articulo $articulo)
    {
        return $articulo;
    }

  
    public function update(ArticuloRequest $request, Articulo $articulo)
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
