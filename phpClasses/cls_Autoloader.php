<?php
class cls_Autoloader
{
    protected static $autoloader = null;

    public static function register()
    {
        if (cls_Autoloader::$autoloader == null) {
            cls_Autoloader::$autoloader = new cls_Autoloader();
        }
    }

    protected function __construct()
    {
        spl_autoload_register(array($this, 'load_class'));
    }

    public function load_class($classname)
    {
        // echo __DIR__ . $classname;
        $path = __DIR__ . "/" . $classname . ".php";
        include_once($path);
    }
}
cls_Autoloader::register();
