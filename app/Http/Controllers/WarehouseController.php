<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Warehouse;
use Session;
use Illuminate\Support\Facades\DB;
class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouses = Warehouse::where('active',1)
                ->paginate(config('app.row'));
        return view('warehouses.index', compact('warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('warehouses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $wh = new Warehouse;
        // $wh->code = $request->code;
        // $wh->name = $request->name;
        // $wh->address = $request->address;
        // $i = $wh->save();
        $i = Warehouse::insert($request->except('_token'));
        if($i)
        {
            return redirect()->route('warehouse.create')->with('success','Data has been save!');
        }
        else
        {
            Session::flash('error','Fail to save data!');
            return redirect('warehouse/create')->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['wh'] = Warehouse::find($id);
        return view('warehouses.edit',$data);
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
        // $wh = Warehouse::find($id);
        // $wh->code = $request->code;
        // $wh->name = $request->name;
        // $wh->address = $request->address;
        // $i = $wh->save();
        $i = Warehouse::where('id',$id)
            ->update($request->except('_token','_method'));
        if($i)
        {
            $value = "Data has been update!";
            return redirect()->route('warehouse.edit',$id)->with('success',$value);
        }
        else
        {
            return redirect()->route('warehouse.edit',$id)->with('error','Fail to update data!');
        }
    }
    public function delete($id)
    {
        $i = Warehouse::where('id',$id)
            ->update(['active'=>0]);
        if($i)
        {
            return redirect('warehouse')->with('success','Data has been removed!');
        }
        else
        {
            return redirect('warehouse')->with('error','Fail to removed data!');
        }
    }

}
