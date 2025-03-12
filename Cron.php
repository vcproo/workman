<?php
require_once __DIR__ . '/vendor/autoload.php';
include 'Conf.php';
include 'db.php';
use Workerman\Worker;
use Workerman\Timer;
use Cron\CronExpression;
$conf = new conf();
$DataCDB = new DataCDB();
$worker = new Worker();
$worker->onWorkerStart = function () use ($conf,$DataCDB) {
    //如果需要实现类似 Cron 的复杂时间规则（如 0 3 * * 1 每周一 3 点），可以结合 mtdowling/cron-expression 库：
    //安装命令 composer require mtdowling/cron-expression
    // 每分钟检查一次任务 每分钟执行一次空检查（未触发时）会占用极少量 CPU，但对现代服务器影响可忽略不计。
    
    Timer::add(60, function () use ($conf,$DataCDB) {
        $cron = CronExpression::factory('0 3 * * 1'); // 每周一 3 点执行
        if ($cron->isDue()) {
            $conf->write_log('每周一3点执行','每周一3点执行');
            $DataCDB->addClient('每周一3点执行',rand(9999,99999));
            echo "每周一凌晨任务触发：" . date('Y-m-d H:i:s') . "\n";
            // 执行周报生成等操作
        }
    });
    // 每隔 60 秒执行一次（类似 Cron 的每分钟任务）
    Timer::add(60, function () use ($conf,$DataCDB) {
        $conf->write_log('分钟触发','每一分钟触发一次');
        $DataCDB->addClient('每分钟触发一次',rand(9999,99999));
        echo "每分钟触发一次" . date('Y-m-d H:i:s') . "\n";
        // 这里编写你的业务逻辑，如清理缓存、发送邮件等
    });

    // 每天凌晨 2 点执行
    Timer::add(3600, function () use ($conf,$DataCDB) { // 每小时检查一次时间
        if (date('H') == 2 && date('i') == 0) { // 凌晨 2:00
            $conf->write_log('每天凌晨2点执行','每天凌晨2点执行');
            $DataCDB->addClient('每天凌晨2点执行',rand(9999,99999));
            //备份数据库
            $conf->backup_mysql();
            //备份库里的某一张表
            $conf->backup_mysql_test();
            echo "每天凌晨2点执行" . date('Y-m-d H:i:s') . "\n";
            // 执行数据库备份等操作
        }
    });
};
Worker::runAll();
?>