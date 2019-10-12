<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/9/11
 * Time: 9:29
 */

namespace app\home\controller;
use app\home\controller\Base as BaseController;
use app\home\model\Attention as AttentionModel;

class Friend extends BaseController
{
    public function attention($friend_id){
        $result=$this->no_loginBefore();
        if($result!=="true"){
            return $result;
        }
        $uid=$this->getUid();
        $AttentionModel=new AttentionModel();
        $AttentionModel->user_id=$uid;
        $AttentionModel->friend_id=$friend_id;
        $result=$AttentionModel->save();

        if($result){
            return [
                'status'=>1,
                'message'=>'关注成功'
            ];
        }else{
            return [
                'status'=>0,
                'message'=>'关注失败'
            ];
        }
    }

    public function noAttention($friend_id){
        $result=$this->no_loginBefore();
        if($result!=="true"){
            return $result;
        }
        $uid=$this->getUid();
        $attention=AttentionModel::get(['user_id'=>$uid,'friend_id'=>$friend_id]);
        $result=$attention->delete();
        if($result){
            return  [
                'status'=>1,
                'message'=>'取消关注成功'
            ];
        }else{
            return [
                'status'=>0,
                'message'=>'取消关注失败'
            ];
        }
    }

}