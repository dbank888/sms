<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 27/05/2017
 * Time: 10:12 AM
 */

namespace App\Http\Controllers;

class ServiceProviderController{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \Response::view('service.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \Response::view('service.create');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return \Response::view('service.edit',['service_id' => $id]);
    }


}