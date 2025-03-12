<?php
date_default_timezone_set('Asia/Shanghai');
class Conf{
    /***数据库 */
    public $hostname_cdb = "localhost";
    public $database_cdb = "test";
    public $username_cdb = "root";
    public $password_cdb = "root";
    public $port_cdb = 3306;


    /**
     * 写入log文件
     * 按天写入 每一天一个文件
     * file_name: 文件名称
     * name: 名称/标识
     * content: 内容
     * @param [type] $str
     * @return void
     */
    public function write_log($name, $content='',$file_name=''){
        //检查有没有log/date('y')文件夹 如果没有就创建 年-月区分
        $path = './log/'.date('Y-m',time());
        $time = date('Y-m-d H:i:s',time());
        if(!file_exists($path)){
            mkdir($path,0777,true);
        }
        if($file_name == ''){
            $file_name = date('Y-m-d',time());
        }   
        
        $path = $path.'/'.$file_name.'.log';
        $str = PHP_EOL."*********************".PHP_EOL;
        $str .= '[时间]'.$time.PHP_EOL;
        $str .= '[标识]'.$name.PHP_EOL;
        $str .= '[内容]'.$content;
        $str .= PHP_EOL."*********************".PHP_EOL;
        file_put_contents($path, $str, FILE_APPEND);

    }

    // public function 
}
?>