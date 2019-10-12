<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/8/8
 * Time: 11:43
 */

namespace app\home\model;
use app\home\model\Base as BaseModel;


class Tread extends BaseModel
{
    public function user(){
       return $this->belongsTo('User','user_id','id');
    }

    public function passage(){
      return  $this->belongsTo('Passage','passage_id','id');
    }
}