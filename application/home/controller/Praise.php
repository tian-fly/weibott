<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/8/1
 * Time: 19:43
 */

namespace app\home\controller;

use app\home\model\Praise as PraiseModel;
use app\home\controller\Base as BaseController;
use think\Controller;
class Praise extends BaseController
{


    public function praise($passage_id,$p_user_id){
        $result=$this->no_loginBefore();
       if($result!=="true"){
             return $result;
        }
        $uid=$this->getUid();
        $praiseModel=new PraiseModel();
        $praiseModel->user_id=$uid;
        $praiseModel->p_user_id=$p_user_id;
        $praiseModel->passage_id=$passage_id;
        $result=$praiseModel->save();

        if($result){
            return [
                'status'=>1,
                'message'=>'点赞成功'
                ];
        }else{
            return [
                'status'=>0,
                'message'=>'点赞失败'
                ];
            }
    }

    public function noPraise($passage_id){
        $result=$this->no_loginBefore();
        if($result!=="true"){
            return $result;
        }
        $uid=$this->getUid();
        $praise=PraiseModel::get(['user_id'=>$uid,'passage_id'=>$passage_id]);
        $result=$praise->delete();
        if($result){
            return  [
                'status'=>1,
                'message'=>'取消点赞成功'
            ];
        }else{
            return [
                'status'=>0,
                'message'=>'取消点赞失败'
            ];
        }
    }





}