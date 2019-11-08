<?php
define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', '');
define('DATABASE', 'websec_auth');
define('CHARSET', 'utf8');

function DB() //does db connection
{
    static $instance;
    if ($instance === null) {
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => FALSE,
        );
        $dsn = 'mysql:host=' . HOST . ';dbname=' . DATABASE . ';charset=' . CHARSET;
        $instance = new PDO($dsn, USER, PASSWORD, $opt);
    }
    return $instance;
}

?>
