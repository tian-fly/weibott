<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/8/3
 * Time: 19:54
 */

namespace app\home\validate;


use think\Validate;

class sendPassage extends Validate
{
   protected  $rule=[
     'content'=>'length:1,500'
   ];
    protected $message=[
      'content.length'=>'内容不能超过500字'
    ];
}