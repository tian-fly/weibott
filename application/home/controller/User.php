<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/8/1
 * Time: 19:11
 */

namespace app\home\controller;
use app\home\controller\Base as BaseController;;
use app\home\validate\changePassword as changePasswordValidate ;
use think\Image;
use think\Request;
use app\home\model\User as UserModel;
use think\Controller;
use app\home\model\Attention as AttentionModel;
use app\home\model\Praise as PraiseModel;
use app\home\model\Tread as TreadModel;
use app\home\model\Friend as FriendModel;
use app\home\model\Passage as PassageModel;
class User extends  BaseController
{
public function test($a,$b){
    $c=$a+$b;
    return $c;
}
//    protected $beforeActionList=['no_login'=>
//        ['only'=>'index,changeBase,changePassword,changeAvatar,saveChangeBaseMessage,saveChangePassword,saveChangeAvatar']
//    ];
    public function index(){
         $this->no_login();
//        $result=$this->no_login();
//        if($result!=="true"){
//            return $result;
//        }
        $uid=$this->getUid();

        $friendList=AttentionModel::friendList($uid);
        $this->assign('friendList',$friendList);

        $onePassages=PassageModel::getPassageByOne($uid);
        $onePassages=$onePassages->hidden(['user.password']);

        $allCount=count($onePassages);
        if($allCount%6==0){
            $page=intval($allCount/6);
        }elseif($allCount>0&&$allCount<6){
            $page=1;
        }elseif($allCount==0){
            $page=0;
        }else{
            $page=intval($allCount/6)+1;
        }

        $this->assign('page',$page);

        $this->assign('onePassages',$onePassages);

        $oneDetail=UserModel::get($uid);
        $coneDetail=$oneDetail->hidden(['password']);
        $this->assign('oneDetail',$coneDetail);

        return  $this->fetch();
    }

    public function message(){
        $this->no_login();
//        $result=$this->no_login();
//        if($result!=="true"){
//            return $result;
//        }
        $uid=$this->getUid();

        $attentionMessage=AttentionModel::with('user')->where(['friend_id'=>$uid])->order('create_time desc')->paginate(5);
        $friendMessage=FriendModel::with('passage')->where(['user_id'=>$uid])->order('create_time desc')->paginate(5);
        $praiseMessage=PraiseModel::with('user,passage')->where(['p_user_id'=>$uid])->order('create_time desc')->paginate(5);
        $treadMessage=TreadModel::with('user,passage')->where(['p_user_id'=>$uid])->order('create_time desc')->paginate(5);

        $this->assign('attentionMessage',$attentionMessage);
        $this->assign('friendMessage',$friendMessage);
        $this->assign('praiseMessage',$praiseMessage);
        $this->assign('treadMessage',$treadMessage);

        return  $this->fetch();
    }

    public function inform(){
        $uid=$this->getUid();
        $count1=AttentionModel::with('user')->where(['friend_id'=>$uid,'status'=>0])->order('create_time desc')->count();
        $count2=FriendModel::with('passage')->where(['user_id'=>$uid,'status'=>0])->order('create_time desc')->count();
        $count3=PraiseModel::with('user,passage')->where(['p_user_id'=>$uid,'status'=>0])->order('create_time desc')->count();
        $count4=TreadModel::with('user,passage')->where(['p_user_id'=>$uid,'status'=>0])->order('create_time desc')->count();
        $count=$count1+$count2+$count3+$count4;
        if($count==0){
            return [
                'status'=>0
            ];
        }else{
            return [
                'status'=>1,
                'message'=>$count
            ];
        }

    }

    public function changeInformStatus(){
        $uid=$this->getUid();
        $pid=input('get.pid');
        $classify=input('get.classify');
        if($classify=='praise'){
            $result=PraiseModel::where(['id'=>$pid,'p_user_id'=>$uid])->update(['status'=>1]);
            if($result){
                return [
                    'status'=>1
                ];
            }else{
                return [
                    'status'=>0,
                    'message'=>'操作异常'
                ];
            }
        }elseif($classify=='friend'){
            $result=FriendModel::where(['id'=>$pid,'user_id'=>$uid])->update(['status'=>1]);
            if($result){
                return [
                    'status'=>1
                ];
            }else{
                return [
                    'status'=>0,
                    'message'=>'操作异常'
                ];
            }
        }elseif($classify=='tread'){
            $result=TreadModel::where(['id'=>$pid,'p_user_id'=>$uid])->update(['status'=>1]);
            if($result){
                return [
                    'status'=>1
                ];
            }else{
                return [
                    'status'=>0,
                    'message'=>'操作异常'
                ];
            }
        }else{
            $result= AttentionModel::where(['id'=>$pid,'friend_id'=>$uid])->update(['status'=>1]);
            if($result){
                return [
                    'status'=>1
                ];
            }else{
                return [
                    'status'=>0,
                    'message'=>'操作异常'
                ];
            }
        }
        return [
            'status'=>0,
            'message'=>'操作异常'
        ];

    }

    public function tourist($uid){
        $data['id']=$uid;
        $onePassages=PassageModel::getPassageByOne($uid);
        $onePassages=$onePassages->hidden(['user.password']);

        $allCount=count($onePassages);
        if($allCount%6==0){
            $page=intval($allCount/6);
        }elseif($allCount>0&&$allCount<6){
            $page=1;
        }elseif($allCount==0){
            $page=0;
        }else{
            $page=intval($allCount/6)+1;
        }

        $this->assign('page',$page);
        $this->assign('onePassages',$onePassages);

        $oneDetail=UserModel::getUser($data);
        $coneDetail=$oneDetail->hidden(['password']);
        $this->assign('oneDetail',$coneDetail);

        return  $this->fetch();
    }



    public function saveRegister(){
        $data=input('post.');
        $result=$this->validate($data,'User.register');
//        $validate	=	Loader::validate('User.register');
//        $result=$validate->batch()->check($data);

        if(true!==$result){
            return  [
                'status'=>0,
                'message'=>$result
//                'message'=>$validate->getError()
            ];
        }
        $datas=Request::instance()->except('rePassword');
        $datas['password']=md5($datas['password']);
        $newUser=UserModel::create($datas);
        if($newUser){
            return  [
                'status'=>1,
                'message'=>'注册成功,请重新登入'
            ];
        }else{
            return  [
                'status'=>0,
                'message'=>'注册失败'
            ];
        }
    }


    //修改个人信息
  public function changeBase(){
      $uid=$this->getUid();
      $user=UserModel::get($uid);
      $userBase=$user->hidden(['password','avatar_url','create_time','avatar_url']);
      $this->assign('userBase',$userBase);
      return $this->fetch();
  }

    public function saveChangeBaseMessage(){
        $data=input('post.');
        $result=$this->validate($data,'User.editBase');
        if(true!==$result){
            return [
                'status'=>0,
                'message'=>$result
            ];
        }
        $uid=$this->getUid();
        $result=UserModel::where(['id'=>$uid])->update($data);
        if($result){
            return [
                'status'=>1,
                'message'=>'修改信息成功'
            ];
        }else{
            return [
                'status'=>0,
                'message'=>'修改信息失败'
            ];
        }
    }



    public function changePassword(){
        return $this->fetch();
    }

    public function saveChangePassword(){
        $data=input('post.');
        $validate=new changePasswordValidate();
        $result=$validate->check($data);
        if(!$result){
            return [
                'status'=>0,
                'message'=>$validate->getError()
            ];

        }
        $uid=$this->getUid();
        $userPassword=UserModel::where(['id'=>$uid])->value('password');
        $password=md5(input('post.password'));
        if($password!==$userPassword){
            return [
                'status'=>0,
                'message'=>'旧密码与原密码不一致'
            ];

        }
        $result=UserModel::where(['id'=>$uid])->update(['password'=>md5(input('post.newPassword'))]);
        if($result){
            return [
                'status'=>1,
                'message'=>'修改密码成功'
            ];
        }else{
            return [
                'status'=>0,
                'message'=>'修改密码失败'
            ];
        }
    }

    public function changeAvatar(){
        $uid=$this->getUid();
        $avatar_url=UserModel::where(['id'=>$uid])->value('avatar_url');
        $this->assign('avatar_url',$avatar_url);
        return $this->fetch();
    }

    public function uploadAvatar(){
            // 获取表单上传文件 例如上传了001.jpg
            $file = request()->file('file');
//        unlink(ROOT_PATH . 'public' . DS . 'user_avatar'.'/20190806\1bb9fffffb4f1219ae3e7a7e0c4fb504.jpg');

            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate(['size'=>200000,'ext'=>'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'user_avatar');

            if($info){
                $image = Image::open(ROOT_PATH . 'public' . DS . 'user_avatar'.'/'.$info->getSaveName());
                // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.png
                $image->thumb(150, 150,Image::THUMB_CENTER)->save(ROOT_PATH . 'public' . DS . 'user_avatar'.'/'.$info->getSaveName());

                //写入数据库
                $uid=$this->getUid();
                $user=UserModel::get($uid);
                if($user->avatar_url){
                    if(file_exists(ROOT_PATH.'public'.$user->avatar_url)){
                        unlink(ROOT_PATH.'public'.$user->avatar_url);
                    }
                }
                $user->avatar_url='/user_avatar/'.$info->getSaveName();
                $result=$user->save();

                if($result){
                    return ['status'=>1,'message'=>'修改头像成功'];
                }else{
                    return ['status'=>0,'message'=>'上传失败，未知错误'];
                }

            }else{
                // 上传失败获取错误信息
                return ['status'=>0,'message'=>$file->getError()];
            }
   }

}