<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/6/16
 * Time: 10:41
 */
namespace app\admin\controller;
use think\Controller;

use app\admin\model\Passage as PassageModel;
use think\Request;
class Passage extends Base{
    public function passage_list(){
        $menu_name=$this->menu_lists();
        $this->assign('menu_list',$menu_name);

        $uid=isset($_GET['uid'])?$_GET['uid']:0;
        if($uid>0){
            $count=PassageModel::passageCountByOne($uid);
            $passage_list=PassageModel::getPassageByOne($uid);
            $passage_list=$passage_list->hidden(['user.password']);
        }else{
            $count=PassageModel::passageCount();
            $passage_list=PassageModel::getAllPassage();
            $passage_list=$passage_list->hidden(['user.password']);
        }

        $this->assign('count',$count);
        $this->assign('passage_list',$passage_list);
        return $this->fetch();
    }
    public function passage_status(Request $request){
        $id=$request->param('id');
        $passage=PassageModel::get($id);
        $passages=PassageModel::where(['type'=>1])->select();
        if($passage->getData('status') == 1){
            PassageModel::update(['status'=>0],['id'=>$id]);
            foreach($passages as $value){
                if($value['pid']==$id){
                    $passageSon=PassageModel::get($value['id']);
                    $passageSon->status=0;
                    $passageSon->save();
                }
            }
        }else{
            PassageModel::update(['status'=>1],['id'=>$id]);
            foreach($passages as $value){
                if($value['pid']==$id){
                    $passageSon=PassageModel::get($value['id']);
                    $passageSon->status=1;
                    $passageSon->save();
                }
            }
        }
    }

    public function passageCountByOne(){
        $id=input('get.uid');
        $count=PassageModel::passageCountByOne($id);
        if($count>0){
            return [
                'status'=>1
            ];
        }else{
            return [
                'status'=>0,
                'message'=>'该用户暂无发表过任何内容'
            ];
        }
    }

    public function comments(){
        $menu_name=$this->menu_lists();
        $this->assign('menu_list',$menu_name);

        $id=input('get.pid');

        $count=PassageModel::commentCount($id);
        $this->assign('count',$count);

        $comments=PassageModel::getPassageComment($id);
        $this->assign('comments',$comments);
        return $this->fetch();
    }

    public function commentCount(){
        $id=input('get.pid');
        $count=PassageModel::commentCount($id);
        if($count>0){
            return [
                'status'=>1
            ];
        }else{
            return [
                'status'=>0,
                'message'=>'该文章暂无评论'
            ];
        }
    }

    public function passage_edit(Request $request){
        $id=$request->param('id');
        $passage=PassageModel::with('user')->where(['id'=>$id])->find();
        $passage=$passage->hidden(['user.password']);
        $this->assign('passage',$passage);
        return $this->fetch();
    }

    public function save_passage(Request $request){
        $id=$request->param('id');
        $data=$request->except('id');
        if($id>0){
            $update=PassageModel::update($data,['id'=>$id]);
            if($update){
                exit(json_encode(array('status'=>1,'message'=>'修改成功')));
            }else{
                exit(json_encode(array('status'=>0,'message'=>'修改失败')));

            }
        }else{
            $insert=PassageModel::create($data);
            if($insert){
                exit(json_encode(array('status'=>1,'message'=>'添加成功')));

            }else{
                exit(json_encode(array('status'=>0,'message'=>'添加失败')));
            }
        }
    }

    public function passage_del(Request $request){
        $id=$request->param('id');

        $passage=PassageModel::get($id);
        $passage->is_delete=0;
        $passage->save();
        $passage->delete();


        $passages=PassageModel::all();
        foreach($passages as $value){
            if($value['pid']==$id){
                $passageSon=PassageModel::get($value['id']);
                $passageSon->is_delete=0;
                $passageSon->save();

                $passageSon->delete();

            }
        }
    }
    public function no_del(){
        PassageModel::update(['is_delete'=>1,'delete_time'=>NULL],['is_delete'=>0]);
    }

    public function search(){
        $time=input('get.time');
        $content=input('get.content');

        if($time){
            $timeArr=explode('~',$time);
            foreach($timeArr as &$value){
                $value=strtotime(trim($value));
            }
        }
        if($content && $time){
            $passages=PassageModel::search($timeArr[0],$timeArr[1],$content);
        }elseif(!$content && $time){

            $passages=PassageModel::search1($timeArr[0],$timeArr[1]);
        }elseif(!$time && $content){
            $passages=PassageModel::search2($content);
        }else{
            echo "<meta http-equiv='content-type' charset='utf-8' content='text/html'>";
            echo "<script>alert('请输入查找内容...');history.back()</script>";
            exit();
        }



        $count=count($passages);

        if($count==0){
            echo "<meta http-equiv='content-type' charset='utf-8' content='text/html'>";
            echo "<script>alert('没有找到相关的内容...');history.back()</script>";
            exit();
        }


        $this->assign('count',$count);

        $this->assign('passage_list',$passages);


        $menu_name=$this->menu_lists();
        $this->assign('menu_list',$menu_name);

        return $this->fetch('passage_list');
    }



    public function passage_delAll(){

        $idsArr=input('post.ids/a');
        foreach($idsArr as $value){
            $passage=PassageModel::get($value);
            $passage->is_delete=0;
            $passage->save();
            $passage->delete();
            $passages=PassageModel::all();
            foreach($passages as $values){
                if($values['pid']==$value){
                    $passageSon=PassageModel::get($values['id']);
                    $passageSon->is_delete=0;
                    $passageSon->save();
                    $passageSon->delete();

                }
            }
        }


        exit(json_encode(array('status'=>1,'message'=>'删除成功')));

    }
}