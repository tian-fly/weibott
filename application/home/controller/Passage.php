<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/8/3
 * Time: 10:06
 */

namespace app\home\controller;
use app\home\model\Attention as AttentionModel;
use app\home\model\Friend as FriendModel;
use app\home\model\Passage as PassageModel;
use app\home\controller\Base as BaseController;
use app\home\model\User as UserModel;
use think\Image;

use app\home\validate\sendPassage as sendPassage;
class Passage extends BaseController
{

    public function search(){
        $content=input('get.content');
        $weiList=PassageModel::search($content);
        $cweiList=$weiList->visible(['id','pid','content','image','type','create_time','user.id','user.user_name','user.avatar_url']);
        $allCount=count($weiList);
        if($allCount%6==0){
            $page=intval($allCount/6);
        }elseif($allCount>0&&$allCount<6){
            $page=1;
        }elseif($allCount==0){
            $page=0;
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

    public function index($passage_id){
          $passageU=PassageModel::getOneWithUser($passage_id);
          $passageUser=$passageU->visible(['id','pid','content','image','type','create_time','user.id','user.user_name','user.avatar_url']);
          $this->assign('passageUser',$passageUser);
          return $this->fetch();
    }

    public function sendPassage(){
        $result=$this->no_loginBefore();
        if($result!=="true"){
            return $result;
        }
        $data=input('post.');
        $validate=new sendPassage();
        if(!$validate->check($data['content'])){
            return  [
                'status'=>0,
                'message'=>$validate->getError()
            ];
        };

        $uid=$this->getUid();
        $user=UserModel::get($uid);
        $result=$user->passages()->save($data);
        if($result){
            if(strstr($data['content'],'@')){
                $reg="/([^@\s]+)/";
                $arr=array();
                preg_match_all($reg,$data['content'],$arr);
                $arr1=array_unique($arr[0]);
                foreach($arr1 as $value){
                    $fid=UserModel::where(['user_name'=>$value])->value('id');
                    $results=AttentionModel::where(['user_id'=>1,'friend_id'=>$fid])->find();

                    if($results){
                        FriendModel::create(['user_id'=>$fid,'passage_id'=>1]);
                    }

                }
            }
            return  [
                'status'=>1,
                'message'=>'发送微博成功'
            ];
        }else{
            return  [
                'status'=>0,
                'message'=>'发送微博失败'
            ];
        }
    }
    public function sendForwardPassage(){
        $result=$this->no_loginBefore();
        if($result!=="true"){
            return $result;
        }
        $data=input('post.');
        $validate=new sendPassage();
        if(!$validate->check($data['content'])){
            return  [
                'status'=>0,
                'message'=>$validate->getError()
            ];
        };

        $data['type']=2;
        $uid=$this->getUid();
        $user=UserModel::get($uid);
        $result=$user->passages()->save($data);
        if($result){
            if(strstr($data['content'],'@')){
                $reg="/([^@\s]+)/";
                $arr=array();
                preg_match_all($reg,$data['content'],$arr);
                $arr1=array_unique($arr[0]);
                foreach($arr1 as $value){
                    $fid=UserModel::where(['user_name'=>$value])->value('id');
                    $results=AttentionModel::where(['user_id'=>1,'friend_id'=>$fid])->find();

                    if($results){
                        FriendModel::create(['user_id'=>$fid,'passage_id'=>1]);
                    }

                }
            }
            return  [
                'status'=>1,
                'message'=>'转发微博成功'
            ];
        }else{
            return  [
                'status'=>0,
                'message'=>'转发微博失败'
            ];
        }
    }



    public function sendComment(){
        $result=$this->no_loginBefore();
        if($result!=="true"){
            return $result;
        }
        $data=input('post.');
        $validate=new sendPassage();
        if(!$validate->check($data['content'])){
            return  [
                'status'=>0,
                'message'=>$validate->getError()
            ];
        };
        $data['type']=1;
        $uid=$this->getUid();
        $user=UserModel::get($uid);
        $result=$user->passages()->save($data);
        $users=UserModel::get($uid);
        if($result){
            return  [
                'status'=>1,
                'message'=>'评论成功',
                'result'=>['avatar_url'=>$users->avatar_url,'user_name'=>$users->user_name,'content'=>$result->content,'create_time'=>$result->create_time]
            ];
        }else{
            return  [
                'status'=>0,
                'message'=>'评论失败'
            ];
        }
    }


    public function upload_images(){
        $result=$this->no_loginBefore();
        if($result!=="true"){
            return $result;
        }

        $uid=$this->getUid();
        // 获取表单上传文件 例如上传了001.jpg
        $file= request()->file('file');

        // 移动到框架应用根目录/public/uploads/ 目录下
//        $info = $file->validate(['size' => 2100000, 'ext' => 'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'user_uploads'.'/'.$uid.'/big');
        $info = $file->validate(['size' => 2100000, 'ext' => 'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'user_uploads'.'/'.$uid.'/big');
        $ext=strrchr($info->getSaveName(),'.');
        if ($info) {

//            $image	=	Image::open(ROOT_PATH.'public'.'/user_uploads/'.$info->getSaveName());
//            $image->thumb(150,	150,Image::THUMB_CENTER)->save(ROOT_PATH.'public'.'/user_uploads/'.$uid.'/small/1.jpg');


            $image	=	Image::open(ROOT_PATH . 'public' . DS . 'user_uploads'.'/'.$uid.'/big/'.$info->getSaveName());

            if(!file_exists(ROOT_PATH . 'public' . DS . 'user_uploads'.'/'.$uid.'/small')){
                mkdir(ROOT_PATH . 'public' . DS . 'user_uploads'.'/'.$uid.'/small');
            }
            $str=date('Ymd',time());
            if(!file_exists(ROOT_PATH . 'public' . DS . 'user_uploads'.'/'.$uid.'/small/'.$str)){
                mkdir(ROOT_PATH . 'public' . DS . 'user_uploads'.'/'.$uid.'/small/'.$str);
            }
            $smallStr='user_uploads'.'/'.$uid.'/small/'.$str.$this->getPictureTime().$ext;
            $smAttr=ROOT_PATH . 'public' . DS ;

            $image->thumb(150,	150,Image::THUMB_CENTER)->save($smAttr.$smallStr);


            $uploadsB = '/user_uploads/'.'/'.$uid.'/big/'.$info->getSaveName();
            $uploadS= '/'.$smallStr;


            $uploadsBarr=session('?uploadsB')?session('uploadsB'):[];
            $uploadsSarr=session('?uploadsS')?session('uploadsS'):[];
            array_push($uploadsBarr,$uploadsB);
            session('uploadsB',$uploadsBarr);
            array_push($uploadsSarr,$uploadS);
            session('uploadsS',$uploadsSarr);


            return ['status' => 1, 'message' => '上传成功', 'uploadB_attr' => $uploadsB,'uploadS_attr'=>$uploadS];

        } else {
            // 上传失败获取错误信息
            return ['status' => 0, 'message' => $file->getError()];
        }
    }


    public function getPictureTime(){
        $str='';
        $str2='';
        $arr=array();
        for($i=0;$i<10;$i++){
            array_push($arr,$i);
        }
       for($i=0;$i<6;$i++){
            $str2.=$arr[rand(0,9)];
       }
        $str.='/'.time().$str2;

        return $str;
    }

    public function test(){
        $str=ROOT_PATH . 'public' . DS . 'user_uploads'.'/test2/1.jpg';
//        $wei=strrpos($str,'.');
//        $wei=substr($str,$wei);
        $wei=strrchr($str,'.');
        return $wei;
    }

    public function getPassageComments($passage_id){
        $comments=PassageModel::getComments($passage_id);
        $ccomments=$comments->visible(['id','pid','content','image','type','create_time','user.id','user.user_name','user.avatar_url']);
        return $ccomments->toArray();
    }

    public function getMoreComments(){
        $passage_id=input('get.passage_id');
        $page=input('get.page');
        $moreComment=PassageModel::getMoreComment($passage_id,$page);
        $moreComment=$moreComment->visible(['id','pid','content','image','type','create_time','user.id','user.user_name','user.avatar_url']);
        if($moreComment){
            return ['status'=>1,'message'=>$moreComment];
        }else{
            return ['status'=>0,'message'=>'加载错误...'];
        }
    }

    public function deleteUploads(){
        $imagesB=input('param.imagesB');
        $imagesS=input('param.imagesS');
        $attr=ROOT_PATH.'public';
        if(file_exists($attr.$imagesB)){
            if(unlink($attr.$imagesB)){
                if(file_exists($attr.$imagesS)){
                    if(unlink($attr.$imagesS)){
                        return ['status'=>1,'message'=>'取消上传成功'];
                    }
                    else{
                         return ['status'=>0,'message'=>'刪除失败，请重试'];
                    }
                }
            }
        }


    }

    public function deletePassage($passage_id){
        $uid=$this->getUid();
        $user=UserModel::get($uid);
        $passage=$user->passages()->getById($passage_id);

        if(!$passage){
            return ['status'=>0,'message'=>'非法操作'];
        }

        $passages=PassageModel::all();
        foreach($passages as $value){
            if($value['pid']==$passage_id){
                $passageSon=PassageModel::get($value['id']);
                $passageSon->is_delete=0;
                $passageSon->save();

                $passageSon->delete();

            }
        }

        if($passage->getData('imagesB')){
            $p=explode(',',$passage->getData('imagesB'));
            $q=explode(',',$passage->getData('imagesS'));
            foreach($p as $value){
                if(file_exists(ROOT_PATH.'public'.$value)){
                    unlink(ROOT_PATH.'public'.$value);
                }
            }
            foreach($q as $value){
                if(file_exists(ROOT_PATH.'public'.$value)){
                    unlink(ROOT_PATH.'public'.$value);
                }
            }
        }

        if($passage->delete()){
            return ['status'=>1,'message'=>'删除成功'];
        }else{
            return ['status'=>0,'message'=>'删除失败'];
        }
    }

}