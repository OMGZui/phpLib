# phpLib

一些好玩的库

## 使用

```bash
git clone https://github.com/OMGZui/phpLib.git
composer install
php -S localhost:8080
访问http://localhost:8080/src/index.php
```

## 标测

```bash
vendor/bin/phpbench run benchmarks/lib
or
vendor/bin/phpbench run benchmarks/lib/trimBench.php
```

## 测试

```bash
vendor/bin/phpunit tests
or
vendor/bin/phpunit tests/strTest.php
```