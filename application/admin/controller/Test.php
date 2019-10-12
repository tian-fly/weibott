<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/9/28
 * Time: 11:46
 */

namespace app\admin\controller;
use think\Controller;
use app\admin\model\Admin as AdminModel;
class Test extends  Controller
{
    public function test1(){
//        $str="1565062074";
//        $time=date("Y-m-d H:i:s",$str);

        $str="2019-08-06";
        $time=strtotime($str);
        dump($time);
    }


    public function test(){
        $admin=AdminModel::get(1);
        $arr=explode(',',$admin['role']['right']);
       dump($arr);
    }
}