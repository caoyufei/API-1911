<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2020/7/20
 * Time: 8:53
 */
$redis=new Redis();

$redis->connect('127.0.0.1',6379);
$redis->set('name1','caoyufei');
$name=$redis->get('name1');
echo $name;