<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//
//];
use think\Route;

//获取网站首页相关信息
Route::get('/','home/Home/index');


//获取个人主页的相关信息
Route::get('visit/:uid','home/User/tourist');
Route::get('personal','home/User/index');
Route::get('message','home/User/message');

//获取消息通知
Route::get('informs','home/User/inform');

//把通知设为已读
Route::get('informStatus','home/User/changeInformStatus');


Route::get('personal/changeBase','home/User/changeBase');
Route::get('personal/changePassword','home/User/changePassword');
Route::get('personal/changeAvatar','home/User/changeAvatar');

Route::post('personal/saveChangeBaseMessage','home/User/saveChangeBaseMessage');
Route::post('personal/saveChangePassword','home/User/saveChangePassword');
//Route::get('personal/saveChangeAvatar','home/User/uploadAvatar');

//打开用户登入页面
Route::get('start_login','home/login/index');
//用户登入验证
Route::post('login','home/login/login');
//获取验证码
Route::get('captcha','/home/login/captcha');

//用户退出
Route::post('logout','home/login/logout');

//用户反馈
Route::get('start_feedback','home/feedback/index');
Route::post('feedback/send','home/feedback/send');


//打开用户注册页面
Route::get('start_register','home/login/register');
//用户注册
Route::post('register','home/User/saveRegister');


//关注用户
Route::post('user/attention','home/Attention/praise');
Route::delete('user/noAttention','home/Attention/noPraise');

//获取某文章详细信息
Route::get('passage/:passage_id','home/Passage/index',[],['passage_id'=>'\d+']);

//获取某文章评论
Route::get('passage/getComment/:passage_id','home/Passage/getPassageComments');
//获取更多的评论
Route::get('passage/comment/more','home/Passage/getMoreComments');

//点赞微博
Route::post('passage/praise','home/Praise/praise');
Route::delete('passage/noPraise','home/Praise/noPraise');

//踩微博
Route::post('passage/tread','home/Tread/tread');
Route::delete('passage/noTread','home/Tread/noTread');

////收藏微博
//Route::post('passage/collect','home/Collect/collect');
//Route::delete('passage/noCollect','home/Collect/noCollect');


//发送微博
Route::post('passage/sendPassage','home/Passage/sendPassage');
Route::post('passage/sendForward','home/Passage/sendForwardPassage');
Route::post('passage/sendComment','home/Passage/sendComment');
//发送图片
Route::post('passage/uploadImages','home/Passage/upload_images');

Route::delete('passage/delete','home/Passage/deletePassage');

//删除上传但不发布的图片
Route::delete('passage/deleteUploads','home/Passage/deleteUploads');


//关注好友
Route::post('user/friend','home/Friend/attention');
Route::delete('user/unFriend','home/Friend/noAttention');