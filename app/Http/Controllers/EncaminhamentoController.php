<?php

namespace App\Http\Controllers;

use App\Encaminhamento;
use Illuminate\Http\Request;

class EncaminhamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('encaminhamento');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Encaminhamento  $encaminhamento
     * @return \Illuminate\Http\Response
     */
    public function show(Encaminhamento $encaminhamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Encaminhamento  $encaminhamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Encaminhamento $encaminhamento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Encaminhamento  $encaminhamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Encaminhamento $encaminhamento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Encaminhamento  $encaminhamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Encaminhamento $encaminhamento)
    {
        //
    }
}
