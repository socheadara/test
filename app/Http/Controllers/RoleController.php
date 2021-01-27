<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request,$next){
            app()->setlocale(Auth::user()->language);
            return $next($request);
        });
    }
    public function index()
    {
        if(!check('role','l'))
        {
            return view('roles.no');
        }
        $data['ro'] = '';
        $data['roles'] = DB::table('roles')
            ->where('active',1)
            ->orderBy('id','desc')
            ->paginate(config('app.row'));
        return view('roles.index',$data);

    }
    public function search(Request $r)
    {
        $data['ro'] = $r->ro;
        $ro = $r->ro;
        $data['roles'] = DB::table('roles')
            ->where('active',1)
            ->where('roles.name','like',"%{$ro}%")
            ->orderBy('id','desc')
            ->paginate(config('app.row'));
        return view('roles.index',$data);

    }
    public function detail($id)
    {
        $data['role'] = DB::table('roles')
                    ->where('id',$id)
                    ->first();
        $sql = "select permissions.id as pid, permissions.alias, tbl.* from permissions
            left join (select * from role_permissions where role_id=$id ) as tbl
            on permissions.id = tbl.permission_id" ;
        $data['permissions'] = DB::select($sql);
        return view('roles.detail', $data);

    }
    public function create()
    {
        if(!check('role','i'))
        {
            return view('roles.no');
        }
        return view('roles.create');
    }
    public function save(Request $r)
    {
        $validate = $r->validate([
            'name' => 'required|min:3|max:200'
        ]);
        $data = array(
            'name' => $r->name
        );
        $i = DB::table('roles')->insert($data);
        if($i)
        {

            return redirect('role/create')->with('success','Data has been saved!');
        }
        else
        {

            return redirect('role/create')->with('error','Fail to saved data!')->withInput();
        }
    }
    public function delete($id, Request $r)
    {
        if(!check('role','d'))
        {
            return view('roles.no');
        }
        DB::table('roles')
            ->where('id',$id)
            ->update(['active'=>0]);

        return redirect('role')->with('success','Data has been removed!');
    }
    public function edit($id)
    {
        if(!check('role','u'))
        {
            return view('roles.no');
        }
        $data['role'] = DB::table('roles')
            ->where('id',$id)
            ->first();
        return view('roles.edit',$data);
    }
    public function update(Request $r)
    {
        if(!check('role','u'))
        {
            return view('roles.no');
        }
        $validate = $r->validate([
            'name' => 'required|min:3|max:200'
        ]);
        $data = array(
            'name' => $r->name
        );
        $i = DB::table('roles')
            ->where('id',$r->id)
            ->update($data);
        if($i)
        {

            return redirect('role/edit/'.$r->id)->with('success','Data has been saved!');
        }
        else
        {

            return redirect('role/edit/'.$r->id)->with('error','Fail to saved data!');
        }
    }
    public function save_permission(Request $r)
    {
        $i = 0;
        if($r->rpid>0)
        {
            // upload role_permissions
            $data = array(
                'role_id' => $r->role_id,
                'permission_id' => $r->pid,
                'list' => $r->list,
                'create' => $r->create,
                'edit' => $r->edit,
                'delete' => $r->del
            );
            DB::table('role_permissions')->where('id',$r->rpid)->update($data);
            $i = $r->rpid;
        }
        else{
            // inser into role_permissions
            $data = array(
                'role_id' => $r->role_id,
                'permission_id' => $r->pid,
                'list' => $r->list,
                'create' => $r->create,
                'edit' => $r->edit,
                'delete' => $r->del
            );
            $i = DB::table('role_permissions')->insertGetid($data);
        }
        return $i;
    }
}
