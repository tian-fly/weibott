<?php
/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/8/1
 * Time: 18:02
 */

namespace app\home\model;


use think\Model;

class Base extends Model
{
    protected $autoWriteTimestamp=true;
    protected $dateFormat='Y-m-d';
    protected $hidden=['update_time','delete_time'];
}