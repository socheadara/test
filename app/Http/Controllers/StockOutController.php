<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class StockOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['q'] = '';
        $data['outs'] = DB::table('stock_outs')
                ->join('warehouses','stock_outs.warehouse_id','warehouses.id')
                ->where('stock_outs.active',1)
                ->select('stock_outs.*','warehouses.name as wname')
                ->paginate(config('app.row'));
        return view('outs.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['ws'] = DB::table('warehouses')
                ->where('active',1)
                ->get();
        $data['products'] = DB::table('products')
                ->join('units','products.unit_id','units.id')
                ->where('products.active',1)
                ->select('products.*','units.name as uname')
                ->get();
        return view('outs.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $m = json_encode($request->master);
        $m = json_decode($m);
        $data = array(
            'out_date' => $m->out_date,
            'reference' => $m->reference,
            'warehouse_id' => $m->warehouse_id,
            'description' => $m->description,
            'out_by' => Auth::user()->id
        );
        $i = DB::table('stock_outs')->insertGetId($data);
        if($i)
        {
            $items = json_encode($request->items);
            $items = json_decode($items);
            foreach($items as $item)
            {
                $in = array(
                    'stock_out_id' => $i,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'warehouse_id' => $m->warehouse_id
                );
                $d = DB::table('stock_out_details')->insert($in);
                Helper::subOnhand($item->product_id,$item->quantity);
                Helper::subWarehouse($m->warehouse_id,$item->product_id,$item->quantity);
            }
        }
        return $i;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $data['out'] = DB::table('stock_outs')
            ->join('warehouses', 'stock_outs.warehouse_id', 'warehouses.id')
            ->where('stock_outs.active', 1)
            ->where('stock_outs.id', $id)
            ->select('stock_outs.*', 'warehouses.name as wname')
            ->first();
        $data['items'] = DB::table('stock_out_details')
            ->join('products','stock_out_details.product_id','products.id')
            ->join('units','products.unit_id','units.id')
            ->where('stock_out_details.stock_out_id',$id)
            ->select('stock_out_details.*','products.code as pcode','products.name as pname','units.name as uname')
            ->get();
        // call warehouses for edit on view detail
        $data['warehouses'] = DB::table('warehouses')
            ->where('active', 1)
            ->get();
        $data['products'] = DB::table('products')
            ->where('active', 1)
            ->get();
        return view('outs.detail',$data);
    }
    public function save_master(Request $r)
    {
        $data = array(
            'out_date' => $r->out_date,
            'warehouse_id' => $r->warehouse_id,
            'reference' => $r->reference,
            'description' => $r->description
        );
        $i = DB::table('stock_outs')
            ->where('id',$r->id)
            ->update($data);
        if($i)
        {
            return $r->id;
        }
        else
        {
            return 0;
        }
    }
    //id of item in stock_out_details
    public function delete_item($id)
    {
        $item = DB::table('stock_out_details')->find($id);
        $i = DB::table('stock_out_details')
            ->where('id',$id)
            ->delete();
        if($i)
        {
            //subtract onhand
            Helper::addOnhand($item->product_id,$item->quantity);
            Helper::addWarehouse($item->warehouse_id,$item->product_id,$item->quantity);
        }
        return $i;
    }
    public function save_new_item(Request $r)
    {
        $data = array(
            'stock_out_id' => $r->id,
            'warehouse_id' => $r->warehouse_id,
            'product_id' => $r->item,
            // $r->item call from modal in view detail name='item' or product
            'quantity' => $r->quantity
        );
        $i = DB::table('stock_out_details')->insert($data);
        if($i)
        {
            //when input stock add onhand qty in stock
            Helper::subOnhand($r->item,$r->quantity);
            //input to any warehouse
            Helper::subWarehouse($r->warehouse_id,$r->item,$r->quantity);
        }
        return redirect('stock-out/detail/'.$r->id);
    }
    public function delete($id)
    {
        $i = DB::table('stock_outs')
            ->where('id',$id)
            ->delete();
        if($i)
        {
            $items = DB::table('stock_out_details')
                ->where('stock_out_id',$id)
                ->get();
            $d = DB::table('stock_out_details')
                ->where('stock_out_id',$id)
                ->delete();
            if($d)
            {
                foreach($items as $item)
                {
                    Helper::addOnhand($item->product_id,$item->quantity);
                    Helper::addWarehouse($item->warehouse_id,$item->product_id,$item->quantity);
                }
            }
        }
        return redirect('stock-out')->with('success','Data has been removed!');
    }
    public function print($id)
    {
        $data['out'] = DB::table('stock_outs')
            ->join('warehouses', 'stock_outs.warehouse_id', 'warehouses.id')
            ->where('stock_outs.active', 1)
            ->where('stock_outs.id', $id)
            ->select('stock_outs.*', 'warehouses.name as wname')
            ->first();
        $data['items'] = DB::table('stock_out_details')
            ->join('products','stock_out_details.product_id','products.id')
            ->join('units','products.unit_id','units.id')
            ->where('stock_out_details.stock_out_id',$id)
            ->select('stock_out_details.*','products.code as pcode','products.name as pname','units.name as uname')
            ->get();
        return view('outs.print',$data);
    }
}
