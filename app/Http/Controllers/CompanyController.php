<?php

namespace App\Http\Controllers;

use App\Models\CompanyModel;
use App\Models\ServiceProviderModel;


class CompanyController{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \Response::view('company.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \Response::view('company.create');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return \Response::view('company.edit',['company_id' => $id]);
    }


}
