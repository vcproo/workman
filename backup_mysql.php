<?php
//备份数据库
// 数据库连接信息
$host = 'localhost';
$username = 'root';
$password = 'root';
$database = 'test';
$file_url = "database_backup";
if(!is_dir($file_url)){
    mkdir($file_url);   
}
$file_url = $file_url.'/'.date('Y-m-d');
if(!is_dir($file_url)){
    mkdir($file_url);   
}

// 备份文件路径
$backupFile = $file_url.'/'.$database . date('Y-m-d_H-i-s') . '.sql';

// 构建 mysqldump 命令，使用完整路径
$mysqldumpPath = 'D:\phpstudy_pro\Extensions\MySQL5.7.26\bin\mysqldump.exe'; // 根据实际路径修改
$command = "\"$mysqldumpPath\" --host=$host --user=$username --password=$password $database > $backupFile";

// 执行命令
exec($command, $output, $returnCode);

if ($returnCode === 0) {
    echo "数据库备份成功，备份文件为: $backupFile";
} else {
    echo "数据库备份失败，错误代码: $returnCode";
}
?>