<?php

namespace App\Http\Controllers;
use RuntimeException;
use BaconQrCode\Encoder\QrCode as EncoderQrCode;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\QrCodeServiceProvider;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index()
    {
        $data['q'] = '';
        $data['products'] = DB::table('products')
                ->join('categories','products.category_id','categories.id')
                ->join('units','products.unit_id','units.id')
                ->where('products.active',1)
                ->select('products.*','categories.name as cname','units.name as uname')
                ->orderBy('id' , 'desc')
                ->paginate(config('app.row'));
        return view('products.index',$data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $r)
    {
        $data['q'] = $r->q;
        $q = $r->q;
        $data['products'] = DB::table('products')
                ->join('categories','products.category_id','categories.id')
                ->join('units','products.unit_id','units.id')
                ->where('products.active',1)
                // if use query where and want to use orwhere so use in where({orwhere})
                ->where(function($query) use($q){
                    $query = $query->orWhere('products.code','like',"%{$q}%")
                        ->orWhere('products.name','like',"%{$q}%")
                        ->orWhere('products.brand','like',"%{$q}%")
                        ->orWhere('products.barcode','like',"%{$q}%")
                        ->orWhere('products.description','like',"%{$q}%")
                        ->orWhere('units.name','like',"%{$q}%")
                        ->orWhere('categories.name','like',"%{$q}%");
                })
                ->select('products.*','categories.name as cname','units.name as uname')
                ->orderBy('id' , 'desc')
                ->paginate(config('app.row'));
        return view('products.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['cats'] = DB::table('categories')
                ->where('active',1)->get();
        $data['units'] = DB::table('units')
                ->where('active',1)->get();
        return view('products.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:products',
            'name' => 'required'

        ]);
        $data = $request->except('_token','photo');
        if($request->photo)
        {
            // $data['photo'] = $request->file('photo')->store('uploads/products','custom');
            // use crop imape save /use getClientOriginalExtension() to bring file .jpg .jpn......
            $file = $request->file('photo');
            $ext = $file->getClientOriginalExtension();
            $file_name = md5(date('Y-m-d-H-i-s')) . "." .$ext;
            // getRealPath() use to crop file / file cuted could path file
            $image = Image::make($file->getRealPath())->resize(450,null,function($aspect){
                $aspect->aspectRatio();
            });
            $image->save('uploads/products/' . $file_name , 80);
            $data['photo'] = 'uploads/products/' . $file_name;
        }
        $i = DB::table('products')->insertGetId($data);

        if($i)
        {
            //generate qrcode
            $qr = "uploads/products/qrcodes/" . $i . "-qrcode.png";
            QrCode::size(500)->format('png')
                    ->generate(url('product/detail/' . $i), public_path($qr));
            DB::table('products')
                ->where('id',$i)
                ->update(['qrcode'=>$qr]);

            return redirect()->route('product.create')->with('success','Data has been saved!');
        }
        else
        {
            return redirect()->route('product.create')->with('error','Fail to save data!');
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
        $data['cats'] = DB::table('categories')
                ->where('active',1)->get();
        $data['units'] = DB::table('units')
                ->where('active',1)->get();
        $data['product'] = DB::table('products')
                ->find($id);
        return view('products.edit',$data);
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
        $data = $request->except('_token','_method','photo');
        $p = DB::table('products')->find($id);
        if($request->photo)
        {
            // $data['photo'] = $request->file('photo')->store('uploads/products/','custom');
            // $data['photo'] upload new photo so delete old photo using command unlink($p->photo)
            // $data['photo'] = $request->file('photo')->store('uploads/products','custom');
            // use crop imape save /use getClientOriginalExtension() to bring file .jpg .jpn......
            $file = $request->file('photo');
            $ext = $file->getClientOriginalExtension();
            $file_name = md5(date('Y-m-d-H-i-s')) . "." .$ext;
            // getRealPath() use to crop file / file cuted could path file
            $image = Image::make($file->getRealPath())->resize(450,null,function($aspect){
                $aspect->aspectRatio();
            });
            $image->save('uploads/products/' . $file_name , 80);
            $data['photo'] = 'uploads/products/' . $file_name;
            unlink($p->photo);

        }
        $i = DB::table('products')->where('id',$id)->update($data);
        if($i)
        {
            return redirect()->route('product.edit',$id)->with('success','Data has been editted successfully!');
        }
        else
        {
            return redirect()->route('product.edit',$id)->with('error','Fail to edit data!');
        }
    }
    public function delete($id)
    {
        DB::table('products')
           ->where('id',$id)
           ->update(['active'=>0]);
        return redirect('product')->with('success','Data has been updated successfuly!');
    }
    public function detail($id)
    {
        $p = DB::table('products')
            ->join('categories','products.category_id','categories.id')
            ->join('units','products.unit_id','units.id')
            ->where('products.id',$id)
            ->select('products.*','categories.name as cname','units.name as uname')
            ->first();
        return view('products.detail',compact('p'));
    }
    public function importfile(Request $r)
    {
        $path = $r->file('file_import')->getRealPath();
        // $data = Excel::import($path, function($reader){ })->get();
        $data = Excel::load($path, function($reader){ })->get();
        if($data->count() && !empty($data))
        {
            foreach($data as $d => $value)
            {
                $product = array(
                    'code' => $value->code,
                    'name' =>$value->name,
                    'barcode' => $value->barcode,
                    'price' =>$value->price,
                    'cost' => $value->cost,
                    'brand' =>$value->brand,
                    'category_id' => $value->category_id,
                    'unit_id' =>$value->unit_id,
                    'description' => $value->description
                );
                DB::table('products')->insert($product);
            }
            if(!empty($product))
            {
                return redirect('product')->with('success','Data has been imported successfully !');
            }
            else
            {
                return redirect('product')->with('error','Fail to import data, please check again!');
            }
        }
    }
}
