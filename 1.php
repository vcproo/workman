<?php
    include 'common.php';
    $conf = new \Conf();
    $conf->write_log('test',date('Y-m-d H:i:s'),'test');



    // file_put_contents('face.log', 'POST'.date('y-m-d h:i:s',time()).'----' . PHP_EOL, FILE_APPEND);
?>