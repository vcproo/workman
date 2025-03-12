<?php
//备份数据库中的某个表
// 数据库连接信息
$host = 'localhost';
$username = 'root';
$password = 'root';
$database = 'test';
$table = 'sys_websocket_client_list';
$file_url = "database_backup";
if(!is_dir($file_url)){
    mkdir($file_url);   
}
$file_url = $file_url.'/'.date('Y-m-d');
if(!is_dir($file_url)){
    mkdir($file_url);   
}

// $backupDir = "D:\phpstudy_pro\WWW\database_backup\";
// 备份文件路径
$backupFile = $file_url .'/'. $database. '_'. $table. date('Y-m-d_H-i-s'). '.sql';

// 构建 mysqldump 命令，使用完整路径
$mysqldumpPath = 'D:\phpstudy_pro\Extensions\MySQL5.7.26\bin\mysqldump.exe'; // 根据实际路径修改
$command = "\"$mysqldumpPath\" --host=$host --user=$username --password=$password $database $table > $backupFile";

// 执行命令
exec($command, $output, $returnCode);

if ($returnCode === 0) {
    echo "数据库表备份成功，备份文件为: $backupFile";
} else {
    echo "数据库表备份失败，错误代码: $returnCode";
}
?>