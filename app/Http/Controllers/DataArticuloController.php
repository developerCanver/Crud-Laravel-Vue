<?php

namespace App\Http\Controllers;

use App\Models\DataTAble\DataArticulo;
use Illuminate\Http\Request;

class DataArticuloController extends Controller
{

    public function index()
    {
        return DataArticulo::all();
       // return DataArticulo::all()->sortByDesc('id');
    }

 
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre'=>'required|min:4|max:150',
            'descripcion'=>'required|min:4',
            'stock'=>'required',
        ]);
        $dataarticulo = new DataArticulo();
        $dataarticulo->create($request->all());
    }

 
    public function show(DataArticulo $dataArticulo)
    {
      
        return $dataArticulo;
    }

   
    public function update(Request $request, DataArticulo $dataArticulo)
    {
        $this->validate($request, [
            'nombre'=>'required|min:4|max:150',
            'descripcion'=>'required|min:4',
            'stock'=>'required',
        ]);
        $dataArticulo->update($request->all());
    }

   
    public function destroy(DataArticulo $dataArticulo)
    {
        $dataArticulo->delete();
    }
}
