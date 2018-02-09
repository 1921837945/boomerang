<?php

namespace App\Http\Controllers;

use App\AdminLog;
use App\Item;
use App\User;
use Illuminate\Http\Request;

class SuperadminController extends Controller
{
    public function add(Request $request)
    {
        User::where('qq = or wechat = or phone = ',[$request,$request,$request])
            ->update(['user_type' => 2]);
    }

    public function delete(Request $request)
    {
        $id = $request->get('id');
        User::where('id',$id)
            ->update(['user_type' => 1]);
    }

    public function adminlist()
    {
        User::where('user_type',2)
            ->select('name');
    }

    public function loglist()
    {
        $logs = AdminLog::latest()
            ->get();
        return $this->apiReponse(200,null,['logs'=>$logs]);
    }











    public function super()
    {
        $user = User::whereIn('user_type',[2,3])
            ->get();

        $itemLost = Item::latest()
            ->where('lost_type',1)
            ->select('uid','title','description','lost_place','lost_type','type_id','images','phone','qq','status')
            ->take(10)
            ->get();
        $itemFind = Item::latest()
            ->where('lost_type',0)
            ->select('uid','title','description','lost_place','lost_type','type_id','images','phone','qq','status')
            ->take(10)
            ->get();

        return $this->apiReponse(200,null,
            ['user' => $user,
                'itemLost' => $itemLost,
                'itemFind' => $itemFind]);

    }
}