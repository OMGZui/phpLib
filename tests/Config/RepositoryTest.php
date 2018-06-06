<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/6/6
 * Time: 17:54
 */

namespace Tests\Config;

use Illuminate\Config\Repository;
use PHPUnit\Framework\TestCase;

class RepositoryTest extends TestCase
{
    protected $repository;
    protected $config;

    protected function setUp()
    {
        $this->repository = new Repository($this->config = [
            'foo' => 'bar',
            'bar' => 'baz',
            'baz' => 'bat',
            'null' => null,
            'associate' => [
                'x' => 'xxx',
                'y' => 'yyy',
            ],
            'array' => [
                'aaa',
                'zzz',
            ],
            'x' => [
                'z' => 'zoo',
            ],
        ]);
        parent::setUp();
    }

    public function testGet()
    {
        $this->assertSame('bar', $this->repository->get('foo'));
    }

    public function testSet()
    {
        $this->repository->set('key', 'value');
        $this->assertSame('value', $this->repository->get('key'));
    }
}