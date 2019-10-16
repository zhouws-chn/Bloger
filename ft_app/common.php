<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use think\Config;

function get_pic_url_from_html($html){
    //echo $cont;
    $pattern_src = '/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i';
    $num = preg_match_all($pattern_src, $html, $match_src);
    $pic_arr = $match_src[1]; //获得图片数组

    return $pic_arr;
    /*foreach ($pic_arr as $pic_item) {
        echo $pic_item;
        echo "  [new]<br />";
    }*/
}

function pic_download_from_url($url, $path = 'uploads/images/')
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    $file = curl_exec($ch);
    curl_close($ch);
    if( $file == false ){
        return $url;
    }
    $config_view_replace_str = config("view_replace_str");

    $filename = pathinfo($url, PATHINFO_BASENAME);
    $path = $path.date("Ymd/");

    $savePath = $config_view_replace_str['__STATIC__'].'/'.$path;
    if(!is_dir($savePath)){
        mkdir($savePath);
    }
    if(strlen($filename)>46){
        return $url;
    }
    $resource = fopen($savePath . $filename, 'a');
    fwrite($resource, $file);
    fclose($resource);

    return '/'.$savePath . $filename;
}