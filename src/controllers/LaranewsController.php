<?php

namespace QQruz\Laranews;

use Illuminate\Http\Request;
use QQruz\Laranews\Request as LaranewsRequest;
use App\Http\Controllers\Controller;

class LaranewsController extends Controller
{
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        LaranewsRequest::create($request->input());

        return back();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {   
        $data = $request->post();
        unset($data['_token']);
        unset($data['_method']);
        $r = LaranewsRequest::where('id', $data['_id']);

        unset($data['_id']);
        $r->update($data);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {   
        LaranewsRequest::destroy($request->input('id'));

        return back();
    }
}
