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
    /**
     * 备份数据库
     */
    public function backup_mysql(){
        $file_url = "database_backup";
        if(!is_dir($file_url)){
            mkdir($file_url);   
        }
        $file_url = $file_url.'/'.date('Y-m-d');
        if(!is_dir($file_url)){
            mkdir($file_url);   
        }
        
        // 备份文件路径
        $backupFile = $file_url.'/'.$this->database_cdb . date('Y-m-d_H-i-s') . '.sql';
        
        // 构建 mysqldump 命令，使用完整路径
        $mysqldumpPath = 'D:\phpstudy_pro\Extensions\MySQL5.7.26\bin\mysqldump.exe'; // 根据实际路径修改
        $command = "\"$mysqldumpPath\" --host=$this->hostname_cdb --user=$this->username_cdb --password=$this->password_cdb $this->database_cdb > $backupFile";
        
        // 执行命令
        exec($command, $output, $returnCode);
        
        if ($returnCode === 0) {
            echo "数据库备份成功，备份文件为: $backupFile";
        } else {
            echo "数据库备份失败，错误代码: $returnCode";
        } 
    }
    /**
     * 备份库里的某一张表
     *
     * @return void
     */
    public function backup_mysql_test(){
        $table = 'sys_websocket_client_list';
        $file_url = "database_backup";
        if(!is_dir($file_url)){
            mkdir($file_url);   
        }
        $file_url = $file_url.'/'.date('Y-m-d');
        if(!is_dir($file_url)){
            mkdir($file_url);   
        }

        // 备份文件路径
        $backupFile = $file_url .'/'. $this->database_cdb. '_'. $table. date('Y-m-d_H-i-s'). '.sql';

        // 构建 mysqldump 命令，使用完整路径
        $mysqldumpPath = 'D:\phpstudy_pro\Extensions\MySQL5.7.26\bin\mysqldump.exe'; // 根据实际路径修改
        $command = "\"$mysqldumpPath\" --host=$this->hostname_cdb --user=$this->username_cdb --password=$this->password_cdb $this->database_cdb $table > $backupFile";

        // 执行命令
        exec($command, $output, $returnCode);

        if ($returnCode === 0) {
            echo "数据库表备份成功，备份文件为: $backupFile";
        } else {
            echo "数据库表备份失败，错误代码: $returnCode";
        }
    }
}
?>