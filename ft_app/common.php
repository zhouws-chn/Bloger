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

function pic_type_detect( $binary )
{
    $types = array(
        6677    => 'bmp',
        7173    => 'gif',
        7368    => 'mp3',
        13780   => 'png',
        255216  => 'jpg',
    );
    $bytes = substr($binary, 0, 2);
    $head = @unpack('C2char', $bytes);
    $typeCode = intval($head['char1'].$head['char2']);
    return isset($types[$typeCode]) ? $types[$typeCode] : 'null';
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
        mkdir($savePath,0777,true);
    }
    if(pic_type_detect($file) == 'null'){
        return $url;
    }
    if(strlen($filename)>40)
        $filename = substr($filename,38).'.'.pic_type_detect($file);
    $resource = fopen($savePath . $filename, 'a');
    fwrite($resource, $file);
    fclose($resource);

    return '/'.$savePath . $filename;
}


function set_replace_str($key, $value)
{
    $old_value = Config::get('view_replace_str');
    if(isset($old_value[$key])==false){
        return false;
    }
    $old_value[$key] = $value;
    $new_content = '<?php'.PHP_EOL.'return [ '.PHP_EOL.' \'view_replace_str\'  =>  ['.PHP_EOL;
    foreach($old_value as $key => $value){
        $new_content = $new_content.'\''.$key.'\'=>\''.$value.'\', '.PHP_EOL;
    }
    $new_content = $new_content.']];';
    $filename = ROOT_PATH.'ft_app\\index\\config.php';
    return file_put_contents($filename,$new_content);
}

/**
 * 循环删除目录和文件
 * @param string $dir_name
 * @return bool
 */
function delete_dir_file($dir_name) {
    $result = false;
    if(is_dir($dir_name)){
        if ($handle = opendir($dir_name)) {
            while (false !== ($item = readdir($handle))) {
                if ($item != '.' && $item != '..') {
                    if (is_dir($dir_name . DS . $item)) {
                        delete_dir_file($dir_name . DS . $item);
                    } else {
                        unlink($dir_name . DS . $item);
                    }
                }
            }
            closedir($handle);
            if (rmdir($dir_name)) {
                $result = true;
            }
        }
    }
    return $result;
}

