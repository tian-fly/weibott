<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/8/3
 * Time: 20:11
 */

namespace app\home\model;
use app\home\model\Base as BaseModel;


class Attention extends BaseModel
{

    public static function friendList($uid){
        return self::with('friend')->where(['user_id'=>$uid])->select();
    }

    public function friend(){
        return $this->belongsTo('User','friend_id','id');
    }

    public function user(){
        return $this->belongsTo('User','user_id','id');
    }
}