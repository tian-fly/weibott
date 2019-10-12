<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/9/11
 * Time: 9:32
 */

namespace app\home\model;
use app\home\model\Base as BaseModel;


class Friend extends BaseModel
{
    public function user(){
        return $this->belongsTo('User','user_id','id');
    }
    public function passage(){
        return $this->belongsTo('Passage','passage_id','id');
    }
}