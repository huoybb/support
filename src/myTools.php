<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/4
 * Time: 15:00
 */

namespace huoybb\support;


class myTools
{
    public static function isOnline()
    {
        return @fopen("http://www.baidu.com/", "r");//判断是否连上网
    }

    public static function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
    static public function isDirOrMkdir($path)
    {
        if (! is_dir($path)) mkdir($path);
        return $path;
    }
    static public function makePath($dirName, $time)
    {
        $year = date('Y', $time);
        $month = date('m', $time);
        $day = date('d', $time);

        $path = static::isDirOrMkdir($dirName . '/');
        $path = static::isDirOrMkdir($path . $year . '/');
        $path = static::isDirOrMkdir($path . $month . '/') ;
        $path = static::isDirOrMkdir($path . $day . '/') ;
        return $path;
    }
    public static function storeAttachment(\Phalcon\Http\Request\File $attachment)
    {
        $uploadDir = 'files'; //上传路径的设置
        $time = time();
        $path = static::makePath($uploadDir,$time);

        $ext = preg_replace('%^.*?(\.[\w]+)$%', "$1", $attachment->getName()); //获取文件的后缀
        $url = md5($attachment->getName());

        $filename = $path . $time . $url . $ext;

        $attachment->moveTo($filename);

        return $filename;
    }
    public static function downloadImage($url){
        $file = file_get_contents($url);

        $uploadDir = 'files'; //上传路径的设置
        $time = time();
        $path = static::makePath($uploadDir,$time);

        $ext = preg_replace('%^.*?(\.[\w]+)$%', "$1", basename($url)); //获取文件的后缀
        $url = md5(basename($url));

        $filename = $path . $time . $url . $ext;
        file_put_contents($filename,$file);
        return $filename;
    }
    public static function camelize($title){
        $words = explode(' ',trim($title));
        foreach($words as $key => $word){
            $words[$key] = \Phalcon\Text::camelize($word);
        }
        return implode(' ',$words);
    }
}