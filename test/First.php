<?php

/**
 * Created by PhpStorm.
 * User: xiaotian
 * Date: 2019/10/15
 * Time: 15:39
 */
namespace app\test;
require_once __DIR__.'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;
use app\home\controller\User;
 class First extends TestCase
{
   public function testTure(){
//       $a=1;
//       $b=2;
       $user=new User();
       $this->assertEquals(5,$user->test(2,2));
   }


 }