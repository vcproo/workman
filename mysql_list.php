<?php
    class MySQLiConnectionPool {
        private $pool = [];
        private $size;
        private $host;
        private $username;
        private $password;
        private $database;
        private $port;
    
        public function __construct($host, $username, $password, $database, $port = 3306,$size = 10 ) {
            $this->host = $host;
            $this->username = $username;
            $this->password = $password;
            $this->database = $database;
            $this->size = $size;
            $this->port = $port;
    
            for ($i = 0; $i < $size; $i++) {
                $this->addConnection();
            }
        }
    
        private function addConnection() {
            $mysqli = new mysqli($this->host, $this->username, $this->password, $this->database, $this->port);
            if ($mysqli->connect_error) {
                throw new Exception('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $this->pool[] = $mysqli;
        }
    
        public function getConnection() {
            if (count($this->pool) > 0) {
                $connection = array_pop($this->pool);
                // 在获取连接时检查连接的有效性
                if (!$connection->ping()) {
                    // 如果连接不可用，则重新建立连接
                    $connection = new mysqli($this->host, $this->username, $this->password, $this->database, $this->port);
                    if ($connection->connect_error) {
                        throw new Exception('Connect Error (' . $connection->connect_errno . ') ' . $connection->connect_error);
                    }
                }
                return $connection;
            } else {
                // 没有可用连接时，尝试创建新连接（不建议过度扩展）
                $connection = new mysqli($this->host, $this->username, $this->password, $this->database, $this->port);
                if ($connection->connect_error) {
                    throw new Exception('Connect Error (' . $connection->connect_errno . ') ' . $connection->connect_error);
                }
                return $connection;
            }
        }
    
        public function releaseConnection($connection) {
            // 在释放连接时检查连接的有效性
            if (!$connection->ping()) {
                // 如果连接不可用，重新建立连接
                $connection->close();
                $connection = new mysqli($this->host, $this->username, $this->password, $this->database, $this->port);
            }
    
            // 释放连接回池中
            if (count($this->pool) < $this->size) {
                $this->pool[] = $connection;
            } else {
                $connection->close();
            }
        }
    }
    
    
?>