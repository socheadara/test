<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
if(!function_exists('check'))
{
    function check($pname,$aname)
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
class Helper
{
    public static function addOnhand($pid , $qty)
    {
        $i = DB::table('products')
            ->where('id',$pid)
            ->increment('onhand' , $qty);
        return $i;
    }
    public static function subOnhand($pid,$qty)
    {
        $i = DB::table('products')
            ->where('id',$pid)
            ->decrement('onhand' , $qty);
        return $i;
    }
    // function for sub item in warehouse to do qty of item
    public static function subWarehouse($wid,$pid,$qty)
    {
        $i = DB::table('product_warehouses')
                ->where('warehouse_id', $wid)
                ->where('product_id', $pid)
                ->decrement('total', $qty);
        return $i;
    }
    //function for add item in warehouse and update qty on item exist
    public static function addWarehouse($wid,$pid,$qty)
    {
        $p = DB::table('product_warehouses')
            ->where('warehouse_id', $wid)
            ->where('product_id', $pid)
            ->first();
        if($p==null)
        {
            // add item not exist
            $i = DB::table('product_warehouses')
                ->insert([
                    'warehouse_id' => $wid,
                    'product_id' => $pid,
                    'total' => $qty
                ]);
        }
        else
        {
            // add item exist
            $i = DB::table('product_warehouses')
                ->where('warehouse_id', $wid)
                ->where('product_id', $pid)
                ->increment('total', $qty);
        }
        return $i;
    }

}

