<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Http\Request;

use Flash;

class ParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameters = Parameter::all();
        return view('parameters.index', ['parameters'=>$parameters]);
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
     * @param  \App\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function show(Parameter $parameter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function edit(Parameter $parameter)
    {
        if (empty($parameter)) {
            Flash::error('Parameter Tidak Ada');

            return redirect(route('parameters.index'));
        }

        $periodeList = array();
        if($parameter->id == 'periodAcademic') {
            $client = new \GuzzleHttp\Client(['verify' => false]);
            $response = $client->request('GET', config('app.api.getPeriodAkademik'));
            $periodeData = json_decode($response->getBody())->data;
            //reformating periode
            foreach ($periodeData as $param) {
                $periodeList[$param->periode] = $param->periode;
            }
        }

        return view('parameters.edit',compact('parameter','periodeList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parameter $parameter)
    {
        if (empty($parameter)) {
            Flash::error('Parameter Tidak Ada');

            return redirect(route('parameters.index'));
        }

        $parameter->update($request->all());

        Flash::success('Berhasil mengubah parameter');
        return redirect(route('parameters.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parameter $parameter)
    {
        //
    }
}
