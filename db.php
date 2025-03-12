<?php
include 'mysql_list.php';
class DataCDB{
    public $cdb;
    public $connectionPool;
    public function __construct(){
        echo '---------------------------'.date('Y-m-d H:i:s',time()).'-----数据库连接池初始化----------------------';
        echo "\n";
        $conf = new Conf();
        $this->connectionPool = new MySQLiConnectionPool($conf->hostname_cdb, $conf->username_cdb, $conf->password_cdb, $conf->database_cdb,$conf->port_cdb);
    }
    /**
     * 添加客户端
     *
     * @return void
     */
    public function addClient($client_id,$mac){
        // 从连接池获取一个连接
        $cdb = $this->connectionPool->getConnection();
        // var_dump($cdb);
        if($mac == ''){
            $mac = 0;
        }
        
        $sql = "INSERT INTO `sys_websocket_client_list1`(`client_id`, `mac`) VALUES ('{$client_id}', '{$mac}')";
        //将sql写入文件
        // file_put_contents("sql.txt", $sql."\n", FILE_APPEND);
        $cdb->query($sql);
        $this->connectionPool->releaseConnection($cdb);
    }

    public function selectClient($mac){
        $cdb = $this->connectionPool->getConnection();
        $sql = "SELECT client_id FROM `sys_websocket_client_list` WHERE mac='{$mac}' order by id desc limit 1";
        $result = $cdb->query($sql);
        $this->connectionPool->releaseConnection($cdb);
        return $result->fetch_assoc();
     }
    /**
     * 删除关闭的客户端
     *
     * @return void
     */
    public function deleteClient($client_id){
        $cdb = $this->connectionPool->getConnection();
        $sql = "DELETE FROM `sys_websocket_client_list` WHERE client_id='{$client_id}'";
        $cdb->query($sql);
        $this->connectionPool->releaseConnection($cdb);
    }
    /**
     * 删除所有客户端
     *
     * @param [type] $client_id
     * @return void
     */
    public function deleteAllClient(){
        $cdb = $this->connectionPool->getConnection();
        $sql = "DELETE FROM `sys_websocket_client_list`";
        $cdb->query($sql);
        $this->connectionPool->releaseConnection($cdb);
    }
    //关闭数据库
    // public function closeDb(){
    //     // $cdb = $this->connectionPool->getConnection();
    //     // // echo "关闭数据库"."\n";
    //     // $cdb->close();
    // }
    // public function __destruct(){
    //     echo "关闭数据库"."\n";
    //     $this->cdb->close();
    // }
}


?>