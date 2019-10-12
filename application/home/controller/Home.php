<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/8/1
 * Time: 17:58
 */

namespace app\home\controller;

use app\home\model\Passage as PassageModel;
use app\home\model\Attention as AttentionModel;
use think\Controller;
use think\Session;
use app\home\controller\Base as BaseController;
class Home extends BaseController
{
    public function index(){
        $weiList=$this->getAllWeiListsWithUser();
        $cweiList=$weiList->visible(['id','pid','content','image','type','create_time','user.id','user.user_name','user.avatar_url']);
        $allCount=PassageModel::count();
        if($allCount%6==0){
            $page=intval($allCount/6);
        }else{
            $page=intval($allCount/6)+1;
        }

        $uid=$this->getUid();
        $friendList=AttentionModel::friendList($uid);
        $this->assign('friendList',$friendList);
        $this->assign('page',$page);
        $this->assign('allWeiList',$cweiList);
        return $this->fetch();
    }


    public function aa()
    {
        $friendList=AttentionModel::friendList(1);
        return $friendList;
    }
    private  function getAllWeiListsWithUser(){
        return PassageModel::getAll();
    }


}