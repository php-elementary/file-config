<?php

namespace elementary\config\Fileconfig;

use elementary\config\Fileconfig\Exceptions\UnsupportedTypeException;
use elementary\config\Fileabstract\FileabstractConfig;

/**
 * @package elementary\config
 */
class Fileconfig
{
    /**
     * @var string
     */
    protected static $dir = '';

    /**
     * @var string
     */
    protected static $serverType = 'Default';

    /**
     * @param string $fileName
     * @param string $separate
     *
     * @return FileabstractConfig
     * @throws UnsupportedTypeException
     */
    public static function load($fileName, $separate='/')
    {
        $file = explode('.', $fileName);
        $ext  = array_pop($file);

        /** @var FileabstractConfig $class */
        $class = '\elementary\config\\'. ucfirst($ext) .'config\\'. ucfirst($ext) .'config';

        if (!class_exists($class)) {
            throw new UnsupportedTypeException('Unsupported '. $ext .' type');
        }

        $class::setDir(self::getDir());
        $class::setServerType(self::getServerType());

        return $class::load($fileName, $separate);
    }

    /**
     * @return string
     */
    public static function getDir()
    {
        return self::$dir;
    }

    /**
     * @param string $dir
     */
    public static function setDir($dir)
    {
        self::$dir = $dir;
    }

    /**
     * @return string
     */
    public static function getServerType()
    {
        return self::$serverType;
    }

    /**
     * @param string $serverType
     */
    public static function setServerType($serverType)
    {
        self::$serverType = $serverType;
    }
}