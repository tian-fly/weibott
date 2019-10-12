<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/8/1
 * Time: 19:43
 */

namespace app\home\controller;

use app\home\model\Tread as TreadModel;
use app\home\controller\Base as BaseController;
use think\Controller;
class Tread extends BaseController
{


    public function tread($passage_id,$p_user_id){
        $result=$this->no_loginBefore();
        if($result!=="true"){
            return $result;
        }
        $uid=$this->getUid();
        $TreadModel=new TreadModel();
        $TreadModel->user_id=$uid;
        $TreadModel->p_user_id=$p_user_id;
        $TreadModel->passage_id=$passage_id;
        $result=$TreadModel->save();

        if($result){
            return [
                'status'=>1,
                'message'=>'踩成功'
            ];
        }else{
            return [
                'status'=>0,
                'message'=>'踩失败'
            ];
        }
    }

    public function noTread($passage_id){
        $result=$this->no_login();
        if($result!=="true"){
            return $result;
        }
        $uid=$this->getUid();
        $praise=TreadModel::get(['user_id'=>$uid,'passage_id'=>$passage_id]);
        $result=$praise->no_loginBefore();
        if($result){
            return  [
                'status'=>1,
                'message'=>'取消踩成功'
            ];
        }else{
            return [
                'status'=>0,
                'message'=>'取消踩失败'
            ];
        }
    }





}