<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class Permission
{
    public static function check1($pname,$aname)
    {
        $role_id = Auth::user()->role_id;
        $query = DB::table('role_permissions')
                ->join('permissions','role_permissions.permission_id', 'permissions.id')
                ->select('role_permissions.*')
                ->where('role_permissions.role_id',$role_id)
                ->where('permissions.name',$pname);
        if($aname == 'l')
        {
            $query = $query->where('role_permissions.list',1);
        }
        else if($aname == 'i')
        {
            $query = $query->where('role_permissions.create',1);
        }
        else if($aname == 'u')
        {
            $query = $query->where('role_permissions.edit',1);
        }
        else if($aname == 'd')
        {
            $query = $query->where('role_permissions.delete',1);
        }
        $query = $query->get();
        return (count($query)>0);
    }
}
