<?php

/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/8/9
 * Time: 11:16
 */
use app\home\model\Passage as PassageModel;
use app\home\model\Praise as PraiseModel;
use app\home\model\Tread as TreadModel;
use app\home\model\Attention as AttentionModel;
function passageComments($passage_id){
    $comments=PassageModel::getComments($passage_id);
    $ccomments=$comments->visible(['id','pid','content','image','type','create_time','user.id','user.user_name','user.avatar_url']);
    return $ccomments;
}

function passageCommentCount($passage_id){
    $count=PassageModel::where(['pid'=>$passage_id,'type'=>1])->count();
    return $count;
}


function getPraiseCount($passage_id){
    $count=PraiseModel::where(['passage_id'=>$passage_id])->count();
    if($count){
        return $count;
    }else{
        return 0;
    }
}

function getTreadCount($passage_id){
    $count=TreadModel::where(['passage_id'=>$passage_id])->count();
    if($count){
        return $count;
    }else{
        return 0;
    }
}

function getForwardsCount($passage_id){
    $count=PassageModel::where(['pid'=>$passage_id,'type'=>2])->count();
    if($count){
        return $count;
    }else{
        return 0;
    }
}

function getCommentsCount($passage_id){
    $count=PassageModel::where(['pid'=>$passage_id,'type'=>1])->count();
    if($count){
        return $count;
    }else{
        return 0;
    }
}

function getPcontent($pid){
    return PassageModel::where(['id'=>$pid])->value('content');
}

function getUname($pid){
    $user=PassageModel::where(['id'=>$pid])->find();
    return $user->user->user_name;
}

function getUid($pid){
    $user=PassageModel::where(['id'=>$pid])->find();
    return $user->user->id;
}



function hasPraise($passage_id){
    return PraiseModel::get(['user_id'=>session('user_info.id'),'passage_id'=>$passage_id]);
}

function hasTread($passage_id){
    return TreadModel::get(['user_id'=>session('user_info.id'),'passage_id'=>$passage_id]);
}

function hasImagesS($pid){
    return PassageModel::where(['id'=>$pid])->value('imagesS');
}

function hasImagesB($pid){
    return PassageModel::where(['id'=>$pid])->value('imagesB');
}


function hasAttention($fid){
    return AttentionModel::get(['user_id'=>session('user_info.id'),'friend_id'=>$fid]);
}

function passageCount($uid){
    return PassageModel::where(['user_id'=>$uid])->count();
}

function fans($uid){
    return AttentionModel::where(['friend_id'=>$uid])->count();
}