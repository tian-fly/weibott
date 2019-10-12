<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/9/6
 * Time: 19:30
 */
use app\admin\model\Passage as PassageModel;
 function getPassageCount($uid){
    return PassageModel::where(['user_id'=>$uid,'type'=>0])->count();
}

function getCommentCount($id){
    return PassageModel::where(['pid'=>$id,'type'=>1])->count();
}

function getPcontent($pid){
    return PassageModel::where(['id'=>$pid])->value('content');
}

function getUname($pid){
    $user=PassageModel::where(['id'=>$pid])->find();
    return $user->user->user_name;
}

function hasImagesS($pid){
    return PassageModel::where(['id'=>$pid])->value('imagesS');
}

function hasImagesB($pid){
    return PassageModel::where(['id'=>$pid])->value('imagesB');
}

function getUid($pid){
    $user=PassageModel::where(['id'=>$pid])->find();
    return $user->user->id;
}