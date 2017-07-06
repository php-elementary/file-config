<?php

namespace elementary\config\Test;

use elementary\config\Fileabstract\FileabstractConfig;
use PHPUnit\Framework\TestCase;
use elementary\config\Fileconfig\Fileconfig;

/**
 * @coversDefaultClass \elementary\config\FileConfig\FileConfig
 */
class FileConfigTest extends TestCase
{
    protected $path    = '/tmp/FileConfigTest';
    protected $default = 'Default';
    protected $file    = 'array.php';

    /**
     * @test
     * @covers ::load()
     */
    public function load()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        file_put_contents($this->getDefault() .'/array2.php', '<?php return ["test" => 123];');

        $this->assertInstanceOf(FileabstractConfig::class, Fileconfig::load('array2.php'));

        unlink($this->getDefault() .'/array2.php');
    }

    /**
     * @test
     * @expectedException \elementary\config\Fileconfig\Exceptions\UnsupportedTypeException
     * @covers ::load()
     */
    public function loadException()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        Fileconfig::load('test.test');
    }

    /**
     * @test
     * @covers ::getDir()
     * @covers ::setDir()
     */
    public function path()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        Fileconfig::setDir('/test23/');
        $this->assertEquals('/test23/', Fileconfig::getDir());
    }

    /**
     * @test
     * @covers ::getServerType()
     * @covers ::setServerType()
     */
    public function serverType()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $this->assertEquals('Default', Fileconfig::getServerType());

        Fileconfig::setServerType('Prod');
        $this->assertEquals('Prod', Fileconfig::getServerType());
    }

    public function setUp()
    {
        $this->setPath(time());

        mkdir($this->getPath());
        mkdir($this->getDefault());

        Fileconfig::setDir($this->getPath());
    }

    public function tearDown()
    {
        if (is_file($this->getDefault() .'/'. $this->file)) {
            unlink($this->getDefault() .'/'. $this->file);
        }

        if (is_dir($this->getDefault())) {
            rmdir($this->getDefault());
        }

        rmdir($this->getPath());
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path.= $path;
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return $this->getPath() .'/'. $this->default;
    }
}
