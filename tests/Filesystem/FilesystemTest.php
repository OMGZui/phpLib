<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/6/6
 * Time: 18:07
 */

namespace Tests\Filesystem;

use Illuminate\Filesystem\Filesystem;
use PHPUnit\Framework\TestCase;
use Mockery as m;

class FilesystemTest extends TestCase
{
    private $tempDir;

    public function setUp()
    {
        $this->tempDir = __DIR__ . '/tmp';
        mkdir($this->tempDir);
    }

    public function tearDown()
    {
        m::close();
        $files = new Filesystem();
        $files->deleteDirectory($this->tempDir);
    }

    public function testGetRetrievesFiles()
    {
        file_put_contents($this->tempDir.'/file.txt', 'Hello World');
        $files = new Filesystem;
        $this->assertEquals('Hello World', $files->get($this->tempDir.'/file.txt'));
    }

    public function testPutStoresFiles()
    {
        $files = new Filesystem;
        $files->put($this->tempDir.'/file.txt', 'Hello World');
        $this->assertStringEqualsFile($this->tempDir.'/file.txt', 'Hello World');
    }
}