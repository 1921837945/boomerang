<?php

namespace App\Http\Controllers;

use App\Api;
use App\Item;
use App\Jobs\SendMsg;
use App\User;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function lostList(Request $request)
    {
        //从items表里取数据
        $page = $request->get('page') ? $request->get('page') : 0;
        $items = Item::
            where('lost_type',0)
            ->select('id', 'uid','title','description','lost_place','lost_type','images','phone','qq','status', 'created_at')
            ->orderBy('id', 'desc')
            ->skip($page * 10)
            ->take(10)

            ->get();


        return $this->apiReponse(200,null,
            ['items' => $items]);
    }

    public function foundList(Request $request)
    {

        //从items表里取数据
        $page = $request->get('page') ? $request->get('page') : 0;
        $items = Item::where('lost_type',1)
            ->select('id', 'uid','title','description','lost_place','lost_type','images','phone','qq','status', 'created_at')
            ->orderBy('id', 'desc')

            ->skip($page * 10)
            ->take(10)
            ->get();

//        //判断所找到的物件是否是校园卡，如果是校园卡返回contact_uno
//        if($type_id = DB::table('items')->where('type_id','=',0)->get())
//        {
//            $item = Item::select('contact_uno')
//                ->where('type_id','=',$type_id->type_id)
//                ->first();
//            return $this->apiReponse(200,null,$item);
//        }

        return $this->apiReponse(200,null,
            ['items' => $items]);

    }

    public function uploadItem(Request $request) {
        $params = $request->all();
        $item = Item::where('id', $params['id'])->update($params);
        return $this->apiReponse(200, '更新成功', null);


    }


    public function createItem(Request $request) {
        $params = $request->all();


        if ($params['contact_uno'] != -1) {
            if (!$user = User::where('uno', $params['contact_uno'])->first()) {
                $openid = Api::unoGetOpenId($params['contact_uno']);
                $user = User::openIdCreateUser($openid);
            }


//            dd(json_encode);
            $user_j = Auth::user();
            $data = array(
                'openid' => $user->openid,
                'data'   => array(
                    'first' => '亲爱的'. mb_substr($user->name, 0, 1, "utf-8") . '同学你好，你的校园卡已被捡到，请认领',
                    'keyword1' =>  mb_substr($user_j->name, 0, 1, "utf-8") . '同学',
                    'keyword2' => '电话 ' . $params['phone'] . ' QQ ' . $params['qq'],
                    'remark'   => '感谢你的使用'
                ),
                'url'   => 'test'
            );
//            dd(json_encode($data));
            SendMsg::dispatch($data);

        }


//        dd($params);
        $item = Item::create($params);

        return $this->apiReponse(200, null, ['item' => $item]);
    }

    public function uploadImg(Request $request) {
        $user = Auth::user();
        $item_id = $request->input('item_id');
//        $file_name = $request->input('file_name');
        $img = $_FILES['file'];
//        dd($img);
        $img_id = $user->uno . "-" . $item_id . "-" . md5_file($img['tmp_name']). $img['name'];
        $img_url =  $user->uno . '/' . $img_id;
//        dd($img);
        Storage::put('public/'.$img_url, File::get($img['tmp_name']));
        $item = Item::where('id', $item_id)->first();
        if (is_array($item->images)) {
//            array_push($item->images, 'storage/'.$img_url);
           // $item->images  = 'storage/'.$img_url;
            $temp = $item->images;
            $temp [] = 'storage/'.$img_url;
            $item->images = $temp;
//            dd($item->images);
        } else {
            $item->images = array(
                'storage/'.$img_url
            );
        }

//        array_push($item->images, 'storage/'.$img_url);

        $item->save();
        return $this->apiReponse(200, '上传成功', null);
    }


    public function deleteImg(Request $request) {
        $item_id = $request->input('item_id');
        $img_id = $request->input('img_id');
        $item = Item::where('id', $item_id)->first();
        $tmp = $item->images;
//        dd($tmp);
        $tmp = array_splice($tmp, $img_id + 1, 1);
//        dd($tmp);
        $item->images = $tmp;
        $item->save();

        return $this->apiReponse( 200, '删除成功', ['item' => $item]);


    }
}
