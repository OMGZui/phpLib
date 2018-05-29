<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2018/5/29
 * Time: 16:51
 */

namespace OMGZui\Obj;

class objFunc
{
    private $data;

    // PHP 5 允行开发者在一个类中定义一个方法作为构造函数。具有构造函数的类会在每次创建新对象时先调用此方法，所以非常适合在使用对象之前做一些初始化工作。
    public function __construct()
    {
        echo "我被构造了<br>";
    }

    public function __destruct()
    {
        echo "我被析构了<br>";
    }

    // serialize() 函数会检查类中是否存在一个魔术方法 __sleep()。如果存在，该方法会先被调用，然后才执行序列化操作。
    public function __sleep()
    {
        return [];
    }

    // unserialize() 会检查是否存在一个 __wakeup() 方法。如果存在，则会先调用 __wakeup 方法，预先准备对象需要的资源。
    public function __wakeup()
    {
    }

    // __toString() 方法用于一个类被当成字符串时应怎样回应。例如 echo $obj; 应该显示些什么。此方法必须返回一个字符串，否则将发出一条 E_RECOVERABLE_ERROR 级别的致命错误。
    public function __toString()
    {
        return "我是对象，你直接输出我？<br>";
    }

    // 当尝试以调用函数的方式调用一个对象时，__invoke() 方法会被自动调用。
    public function __invoke()
    {
        echo "我是对象，你直接回调我？<br>";
    }

    // 在对象中调用一个不可访问方法时，__call() 会被调用。
    public function __call($name, $arguments)
    {
        echo "没这个方法，你调用个啥啊？<br>";
    }

    // 在静态上下文中调用一个不可访问方法时，__callStatic() 会被调用。
    public static function __callStatic($name, $arguments)
    {
        echo "没这个静态方法，你调用个啥啊？<br>";
    }

    // 当对不可访问属性调用 isset() 或 empty() 时，__isset() 会被调用。
    public function __isset($name)
    {
        echo "你没权限判断啊<br>";
        return isset($this->data[$name]);
    }

    // 当对不可访问属性调用 unset() 时，__unset() 会被调用。
    public function __unset($name)
    {
        echo "你没权限销毁啊<br>";
        unset($this->data[$name]);
    }

    // 在给不可访问属性赋值时，__set() 会被调用。
    public function __set($name, $value)
    {
        echo "你没权限赋值啊<br>";
        $this->data[$name] = $value;
    }

    // 读取不可访问属性的值时，__get() 会被调用。
    public function __get($name)
    {
        echo "你没权限获取啊<br>";
        return "{$this->data[$name]}<br>";
    }

    // 当复制完成时，如果定义了 __clone() 方法，则新创建的对象（复制生成的对象）中的 __clone() 方法会被调用，可用于修改属性的值（如果有必要的话）。
    public function __clone()
    {
        echo "我浅复制了一个对象<br>";
    }

}