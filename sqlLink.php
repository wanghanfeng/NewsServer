<?php
/**
 * Created by PhpStorm.
 * User: whf
 * Date: 17/2/8
 * Time: 下午5:46
 */

$conn = mysqli_connect('localhost','root','','news_server');
mysqli_set_charset($conn,'utf8');

function writeTable($tableName,$item){
    global $conn;
    
    $value = '';
    foreach ($item as $v){
        $value = $value . '"' . $v . '"' . ',';
    }
    //处理当长度不匹配时插入数据库报错
    if (count($item)==7){
        $value = $value . "null" . ',' . "null" . ',';
    }
    if (count($item)==8){
        $value = $value . "null" . ',';
    }
    if (strlen($value)!=0){
        $value = substr($value,0,strlen($value)-1);
    }
    $sql = "insert into $tableName VALUES ($value)";
//    echo '数据库写入成功!' . $sql . '<br/>';
    if (!mysqli_query($conn,$sql)){
//        echo '数据库写入失败!' . $sql .'<br/>';
    }
}

//function readTable($tableName,$)