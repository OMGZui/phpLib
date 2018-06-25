<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/6/25
 * Time: 19:56
 */
namespace Tests\Database;

use PDO;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testSettingDefaultCallsGetDefaultGrammar()
    {
        $connection = $this->getMockConnection();
        $mock = m::mock('stdClass');
        $connection->expects($this->once())->method('getDefaultQueryGrammar')->will($this->returnValue($mock));
        $connection->useDefaultQueryGrammar();
        $this->assertEquals($mock, $connection->getQueryGrammar());
    }

    public function testSelectProperlyCallsPDO()
    {
        $pdo = $this->getMockBuilder('Tests\Database\DatabaseConnectionTestMockPDO')->setMethods(['prepare'])->getMock();
        $writePdo = $this->getMockBuilder('Tests\Database\DatabaseConnectionTestMockPDO')->setMethods(['prepare'])->getMock();
        $writePdo->expects($this->never())->method('prepare');
        $statement = $this->getMockBuilder('PDOStatement')->setMethods(['execute', 'fetchAll', 'bindValue'])->getMock();
        $statement->expects($this->once())->method('bindValue')->with('foo', 'bar', 2);
        $statement->expects($this->once())->method('execute');
        $statement->expects($this->once())->method('fetchAll')->will($this->returnValue(['boom']));
        $pdo->expects($this->once())->method('prepare')->with('foo')->will($this->returnValue($statement));
        $mock = $this->getMockConnection(['prepareBindings'], $writePdo);
        $mock->setReadPdo($pdo);
        $mock->expects($this->once())->method('prepareBindings')->with($this->equalTo(['foo' => 'bar']))->will($this->returnValue(['foo' => 'bar']));
        $results = $mock->select('foo', ['foo' => 'bar']);
        $this->assertEquals(['boom'], $results);
        $log = $mock->getQueryLog();
        $this->assertEquals('foo', $log[0]['query']);
        $this->assertEquals(['foo' => 'bar'], $log[0]['bindings']);
        $this->assertInternalType('numeric', $log[0]['time']);
    }

    public function testInsertCallsTheStatementMethod()
    {
        $connection = $this->getMockConnection(['statement']);
        $connection->expects($this->once())->method('statement')
            ->with($this->equalTo('foo'), $this->equalTo(['bar']))
            ->will($this->returnValue('baz'));
        $results = $connection->insert('foo', ['bar']);
        $this->assertEquals('baz', $results);
    }

    public function testUpdateCallsTheAffectingStatementMethod()
    {
        $connection = $this->getMockConnection(['affectingStatement']);
        $connection->expects($this->once())->method('affectingStatement')
            ->with($this->equalTo('foo'), $this->equalTo(['bar']))
            ->will($this->returnValue('baz'));
        $results = $connection->update('foo', ['bar']);
        $this->assertEquals('baz', $results);
    }

    public function testDeleteCallsTheAffectingStatementMethod()
    {
        $connection = $this->getMockConnection(['affectingStatement']);
        $connection->expects($this->once())->method('affectingStatement')
            ->with($this->equalTo('foo'), $this->equalTo(['bar']))
            ->will($this->returnValue('baz'));
        $results = $connection->delete('foo', ['bar']);
        $this->assertEquals('baz', $results);
    }


    protected function getMockConnection($methods = [], $pdo = null)
    {
        $pdo = $pdo ?: new DatabaseConnectionTestMockPDO;
        $defaults = ['getDefaultQueryGrammar', 'getDefaultPostProcessor', 'getDefaultSchemaGrammar'];
        $connection = $this->getMockBuilder('Illuminate\Database\Connection')->setMethods(array_merge($defaults, $methods))->setConstructorArgs([$pdo])->getMock();
        $connection->enableQueryLog();
        return $connection;
    }
}

class DatabaseConnectionTestMockPDO extends PDO
{
    public function __construct()
    {
    }
}