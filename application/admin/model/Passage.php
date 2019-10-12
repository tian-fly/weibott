<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/9/27
 * Time: 18:23
 */

namespace app\admin\model;
use app\admin\model\Base as BaseModel;
use  traits\model\SoftDelete;
class Passage extends BaseModel
{
    use  SoftDelete;
    public static function passageCount(){
        $arr=array('in','0,2');
        return self::where(['type'=>$arr])->count();
    }

   public static function getAllPassage(){
       $arr=array('in','0,2');
       return self::with('user')->where(['type'=>$arr])->order('create_time desc')->paginate(7);
   }

    public static function getPassageComment($pid){
        return self::where(['pid'=>$pid,'type'=>1])->paginate(7);
    }

    public static function passageCountByOne($uid){
        $arr=array('in','0,2');
        return self::where(['user_id'=>$uid,'type'=>$arr])->count();
    }

    public static function getPassageByOne($uid){
        $arr=array('in','0,2');
        return self::where(['user_id'=>$uid,'type'=>$arr])->paginate(7);
    }

    public static function commentCount($pid){
        return self::where(['pid'=>$pid,'type'=>1])->count();
    }

    public static function getOnePassage($pid){
        return self::with(['user'])->find();
    }

    public function getStatusAttr($value){
        $status=[
            0=>'已停用',
            1=>'已启用'
        ];
        return $status[$value];
    }

    public function getContentAttr($value){

        $value=preg_replace('/\[em_([0-9]*)\]/',"<img src='/static/images/face/$1.gif'>",$value);
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

    public static function search($l,$r,$content){
        $contentArr=array('like','%'.$content.'%');
        $timeArr=array('between',[$l,$r]);
        return self::where(['create_time'=>$timeArr,'content'=>$contentArr,'type'=>0])->paginate(7);
    }

    public static function search1($l,$r){
        $timeArr=array('between',[$l,$r]);
        return self::where(['create_time'=>$timeArr,'type'=>0])->paginate(7);
    }

    public static function search2($content){
        $contentArr=array('like','%'.$content.'%');
        return self::where(['content'=>$contentArr,'type'=>0])->paginate(7);
    }


    public function user(){
        return $this->belongsTo('User','user_id','id');
    }


}