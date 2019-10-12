<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/8/1
 * Time: 19:48
 */

namespace app\home\model;

use app\home\model\Base as BaseModel;

class User  extends BaseModel

{

    public function getAvatarUrlAttr($value){
        return "http://www.weibott.com".$value;
    }

    public static function getUser($data){
        return self::where($data)->find();
    }



//       public static function getOneWithPassages($id){
////        return self::get($id,['passages']);
//       return self::with(['passages'=>function($query){
//            $query->where(['type'=>['in','0,2']])->order('create_time desc');
//        }])->where(['id'=>$id])->find();
//    }

//[
//'imgs' => function ($query)
//{
//    $query->with(['imgUrl'])
//        ->order('order', 'asc');
//}]
    //获取个人文章
//    public static function getOnePassages($id){
//        $user=self::get($id);
//        $user_passages=$user->passages;
//        return $user_passages;
//    }

    public function passages(){
        return $this->hasMany('Passage','user_id','id');
    }
}