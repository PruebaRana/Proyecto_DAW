<?php
class ConexionBD extends PDO
{
    private static $instance = null;
 
    public function __construct()
    {
        $config = Config::singleton();
        parent::__construct('mysql:host='.$config->get('dbhost').';dbname='.$config->get('dbname'), $config->get('dbuser'), $config->get('dbpass'));

		//Realiza el enlace con la BD en utf-8
		parent::exec("set names utf8");
		parent::setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, TRUE);
	}
 
    public static function singleton()
    {
        if( self::$instance == null )
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
?>