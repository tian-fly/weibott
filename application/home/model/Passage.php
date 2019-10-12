<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/8/1
 * Time: 18:01
 */

namespace app\home\model;
use app\home\model\Base as BaseModel;

class Passage extends BaseModel
{

    public function getContentAttr($value){

        $value=preg_replace('/\[em_([0-9]*)\]/',"<img src='http://www.weibott.com/static/images/face/$1.gif'>",$value);
        return $value;
    }


    public function getCreateTimeAttr($value){
        $adate=date('m-d H:i',$value);
        $zdate=date('H:i',$value);
        $time=time()-$value;
        if($time<60){
            return '刚刚';
        }elseif($time<(60*60)){
            $mtime=intval($time/60);
            return $mtime.'分钟前';
        }elseif($time<(60*60*24)){
            $htime=intval($time/(60*60));
            return $htime.'小时前';
        }elseif($time<(60*60*24*2)){
            return "昨天".'->'.$zdate;
        }elseif($time<(60*60*24*3)){
            return "前天".'->'.$zdate;
        }else{
            return $adate;
        }
    }

    //获取所有微博 分页 简易
    public static function getAll(){
        $arr=array('in','0,2');
        return self::with('user')->where(['type'=>$arr])->order('create_time desc')->paginate(6);
    }

//    public static function getPersonal(){
//        return self::order('create_time desc')->paginate(10,true);
//    }


    public static function search($content){
        $content=array('like','%'.$content.'%');
        $arr=array('in','0,2');
        return self::with('user')->where(['type'=>$arr,'content'=>$content])->order('create_time desc')->paginate(6);
    }


    public static function getOneWithUser($passage_id){
        return self::get($passage_id,['user']);
    }


    public function user(){
        return $this->belongsTo('User','user_id','id');
    }

    public static function getComments($passage_id){
        return self::with('user')->where(['pid'=>$passage_id,'type'=>1])->limit(3)->order('create_time desc')->select();
    }

   public static function getMoreComment($passage_id,$page){
       return self::with('user')->where(['pid'=>$passage_id,'type'=>1])->limit($page,3)->select();
   }

    public static function getPassageByOne($uid){
        return self::with('user')->where(['user_id'=>$uid,'type'=>['in','0,2']])->order('create_time desc')->paginate(10);
    }

}