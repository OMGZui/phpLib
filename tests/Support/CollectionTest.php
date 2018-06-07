<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/6/7
 * Time: 10:48
 */
namespace Tests\Support;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{

    public function testUnique()
    {
        $c = new Collection(['Hello', 'World', 'World']);
        $this->assertEquals(['Hello', 'World'], $c->unique()->all());

        $c = new Collection([[1, 2], [1, 2], [2, 3], [3, 4], [2, 3]]);
        $this->assertEquals([[1, 2], [2, 3], [3, 4]], $c->unique()->values()->all());
    }

    public function testHigherOrderUnique()
    {
        $c = new Collection([
            ['id' => '1', 'name' => 'first'],
            ['id' => '1', 'name' => 'second'],
        ]);

        $this->assertCount(1, $c->unique->id);
        $this->assertSame($c->unique('id')->all(), $c->unique->id->all());
    }

    public function testMap()
    {
        $data = new Collection(['first' => 'taylor', 'last' => 'otwell']);
        $data = $data->map(function ($item, $key) {
            return $key.'-'.strrev($item);
        });
        $this->assertEquals(['first' => 'first-rolyat', 'last' => 'last-llewto'], $data->all());
    }

    public function testHigherOrderCollectionMap()
    {
        $person1 = (object) ['name' => 'Taylor'];
        $person2 = (object) ['name' => 'Yaz'];

        $collection = collect([$person1, $person2]);

        $this->assertEquals(['Taylor', 'Yaz'], $collection->map->name->toArray());
        $this->assertEquals(['Taylor', 'Yaz'], $collection->map(function ($item){
            return $item->name;
        })->toArray());

        $collection = collect([new TestSupportCollectionHigherOrderItem, new TestSupportCollectionHigherOrderItem]);

        $this->assertEquals(['TAYLOR', 'TAYLOR'], $collection->each->uppercase()->map->name->toArray());
        $this->assertEquals(['TAYLOR', 'TAYLOR'], $collection->each(function ($item){
            return $item->uppercase();
        })->map(function ($item){
            return $item->name;
        })->toArray());
    }
}

class TestSupportCollectionHigherOrderItem
{
    public $name;

    public function __construct($name = 'taylor')
    {
        $this->name = $name;
    }

    public function uppercase()
    {
        return $this->name = strtoupper($this->name);
    }
}