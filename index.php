<?php

require 'vendor/autoload.php';

use Qiniu\Auth;

// 用于签名的公钥和私钥
$accessKey = '9BrolDMS4-iOwAlWu3OHNKfxA7ql6fWjfIimAsF_';
$secretKey = '3eT5jKoSBGx4KcNS4lo1iNP8yqlHbSdPpg2j86Zn';
$bucket = 'fafu';

$file = getNowFileName();
if($file)
{
    // 初始化签权对象
    $auth = new Auth($accessKey, $secretKey);
    // 生成上传Token
    $token = $auth->uploadToken($bucket);
    // 构建 UploadManager 对象
    $uploadMgr = new \Qiniu\Storage\UploadManager();
    // 要上传文件的本地路径
    $filePath = '/home/mysql_backup/'.$file;
    // 上传到七牛后保存的文件名
    $key = $file;
    // 调用 UploadManager 的 putFile 方法进行文件的上传
    list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
    echo "\n====> putFile result: \n";
    if ($err !== null)
    {
        var_dump($err);
    }
    else
    {
        var_dump($ret);
    }
}

/**
 * 获取最新备份文件的名称
 * @return string
 * create by wenQing
 */
function getNowFileName()
{
    //获取某目录下所有文件、目录名（不包括子目录下文件、目录名）
    $localFile = scandir('/home/mysql_backup/');
    if(is_array($localFile))
    {
        $time = ''; //保存获取到最新事件的文件
        foreach($localFile as $v)
        {
            preg_match('/product_fafu_(.*?).sql/',$v,$re);
            if(is_array($re) && !empty($re))
            {
                $time = ($re[1] > $time ? $re[1] : $time);
            }
        }
    }
    return $time ? 'product_fafu_'.$time.'.sql' : '';
}
