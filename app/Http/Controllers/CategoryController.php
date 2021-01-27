<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['categories'] = DB::table('categories')
                ->where('active',1)
                ->orderBy('id','desc')
                ->paginate(config('app.row'));
        return view('categories.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $i = DB::table('categories')
            ->insert($request->except('_token'));
        if($i)
        {
            $value = "Data has been saved!";
            Session::flash('success', $value);
            return redirect('category/create');
        }
        else
        {
            $value = "Fail to saved data!";
            Session::flash('error', $value);
            return redirect('category/create')->withInput();
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
        $cat = DB::table('categories')->find($id);
        return view('categories.edit',compact('cat'));
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
        $i = DB::table('categories')
            ->where('id',$id)
            ->update(['name'=>$request->name]);
        if($i)
        {
            $value = "Data has been updated!";
            // Session::flash('success',$value);
            // return redirect("category/{$id}/edit");
            // return redirect()->route('category.edit',$id);
            return redirect()->route('category.edit',$id)->with('success',$value);
        }
        else
        {
            $value = "Fail to update data!";
            Session::flash('error',$value);
            // return redirect("category/{$id}/edit");
            return redirect()->route('category.edit',$id);
        }
    }
    public function delete($id)
    {
        $i  = DB::table('categories')
            ->where('id',$id)
            ->update(['active'=>0]);
        if($i)
        {
            // use name route
            return redirect()->route('category.index')
            ->with('success','Data has been removed!');
        }
        else
        {
            // use url
            return redirect('category')->with('error','Fail to removed data!');
        }
    }
}
