<?php
/**
 * Created by PhpStorm.
 * User: whf
 * Date: 17/2/8
 * Time: 下午4:20
 */

include 'sqlLink.php';

/**
 * 发送post请求
 * @param string $url 请求地址
 * @param array $post_data post键值对数据
 * @return array
 */
function send_post($url,$post_data, $header_arr=null) {

    $postdata = http_build_query($post_data);
    $header = '';
    foreach ($header_arr as $key => $value){
        $header = $header . $key . ':' .$value . '\n';
    }
    if (strlen($header)!=0){
        $header = substr($header,0,strlen($header)-1);
    }
    else{
        $header = 'Content-type:application/x-www-form-urlencoded';
    }
    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => $header,
            'content' => $postdata,
            'timeout' => 0.5 * 60 // 超时时间（单位:s）
        )
    );
    $context = stream_context_create($options);
    $body = file_get_contents($url, false, $context);
    //获取响应头
    $header = $http_response_header;

    $result = [
        'header' => $header,
        'body' => $body
    ];
    return $result;
}

$post_data = array(
    'type' => 'keji',
    'key' => '9b36e7f06020e794a3547c5718bc114c'
);
$res = send_post('https://v.juhe.cn/toutiao/index', $post_data)['body'];

//打印响应头
//foreach ($res as $key => $value){
//    echo $value .'<br/>';
//}

$arr = json_decode($res,true);
echo json_encode($arr);
//把数据写入数据库保存
foreach ($arr['result']['data'] as $v){
    writeTable('news',$v);
}

function show($v){
    if (is_array($v)){
        foreach ($v as $key => $value){
            if (is_array($value)){
                show($value);
            }
            else{
                echo $key . ' : ' . $value .'<br/>';
            }
        }
    }
}
//show($arr['result']['data']);

