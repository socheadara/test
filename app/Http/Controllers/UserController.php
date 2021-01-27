<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request,$next){
            app()->setlocale(Auth::user()->language);
            return $next($request);
        });
    }
    // write in controller Route::group(['middleware'=>'auth'],function(){write route all in this block });
    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
    public function index()
    {
        $data['us'] = "";
        if(!check('user','l'))
            {
                return view('roles.no');
            }
        $data['users'] = DB::table('users')
            ->where('users.active',1)
            ->join('roles','users.role_id','roles.id')
            ->orderBy('users.id','desc')
            ->select('users.*','roles.name as rname')
            ->paginate(config('app.row'));
        return view('users.index',$data);
    }
    public function search(Request $r)
    {
        $data['us'] = $r->us;
        $us = $r->us;
        $data['users'] = DB::table('users')
            ->join('roles','users.role_id','roles.id')
            ->where(function($query) use($us){
                $query = $query->orWhere('users.name','like',"%{$us}%")
                               ->orWhere('users.username','like',"%{$us}%")
                               ->orWhere('users.email','like',"%{$us}%");
            })
            ->where('users.active',1)
            ->orderBy('users.id','desc')
            ->select('users.*','roles.name as rname')
            ->paginate(config('app.row'));
        return view('users.index',$data);
    }
    public function create()
    {
        if(!check('user','i'))
        {
            return view('roles.no');
        }
        $data['roles'] = DB::table('roles')
                ->where('active',1)
                ->get();
        return view('users.create',$data);
    }
    public function delete($id,Request $r)
    {
        if(!check('user','d'))
        {
            return view('roles.no');
        }
        DB::table('users')
            ->where('id',$id)
            ->update(['active'=>0]);

        return redirect('user')->with('success','Data has been removed!');
    }
    public function edit($id)
    {
        if(!check('user','u'))
        {
            return view('roles.no');
        }
        $data['roles'] = DB::table('roles')
                ->where('active',1)
                ->get();
        $data['user'] = DB::table('users')
            ->where('id',$id)
            ->first();
        return view('users.edit',$data);
    }
    public function save(Request $r)
    {
        $validatedData = $r->validate([
            'name' => 'required|unique:users|min:3|max:255',
            'email' => 'required',
            'username' => 'required|min:3|unique:users',
            'password' => 'required|min:3'
        ]);
        $data = array(
            'name' => $r->name,
            'email' => $r->email,
            'username' => $r->username,
            'role_id' => $r->role,
            'language' => $r->language,
            'password' => bcrypt($r->password)
        );
        if($r->photo)
        {
            $data['photo'] = $r->file('photo')->store('uploads/users','custom');
        }
        $i = DB::table('users')->insert($data);
        if($i)
        {

            return redirect('user/create')->with('success','Data has been save!');
        }
        else
        {

            return redirect('user/create')->with('error','Fail to save data!')->withInput();
        }
    }
    public function update(Request $r)
    {
        if(!check('user','u'))
        {
            return view('roles.no');
        }
        $validatedData = $r->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required',
            'username' => 'required|min:3'
        ]);
        $data = array(
            'name' => $r->name,
            'email' => $r->email,
            'username' => $r->username,
            'language' => $r->language,
            'role_id' => $r->role

        );
        if($r->password!='')
        {
            $data['password'] = bcrypt($r->password);
        }
        if($r->photo)
        {
            $data['photo'] = $r->file('photo')->store('uploads/users','custom');
        }
        $i = DB::table('users')
            ->where('id',$r->id)
            ->update($data);
        if($i)
        {

            return redirect('user/edit/'.$r->id)->with('success','Data has been save!');
        }
        else
        {

            return redirect('user/edit/'.$r->id)->with('error','Fail to save data!');
        }
    }
}
