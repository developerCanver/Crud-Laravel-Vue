<?php

namespace App\Http\Controllers;

use App\Models\DataTAble\DataArticulo;
use Illuminate\Http\Request;

class DataArticuloController extends Controller
{

    public function index()
    {
        return DataArticulo::all();
        //return DataArticulo::all()->sortByDesc('id');
    }

 
    public function store(Request $request)
    {
        $dataarticulo = new DataArticulo();
        $dataarticulo->create($request->all());
    }

 
    public function show(DataArticulo $dataArticulo)
    {
        return $dataArticulo;
    }

   
    public function update(Request $request, DataArticulo $dataArticulo)
    {
        $dataArticulo->update($request->all());
    }

   
    public function destroy(DataArticulo $dataArticulo)
    {
        $dataArticulo->delete();
    }
}
