# php-benchmark
A simple PHP Benchmark class.

## Example usage
### Functions
``` php
<?php 

$w1 = new Workbench(['param', 10], 1);
$w2 = new Workbench(['param', 100], 333);

$b = new Benchmark(function($p1, $p2) {
    return $p1 . (string) $p2 * 100;
}, $w1, $w2;

$r = $b->startTest()->getResult();

var_dump(
    $r->getBenchmarkResult(0)->getAverageTime(),
    $r->getBenchmarkResult(1)->getAverageTime(),
    $r->getAverageTime()
);
```
### Classes
``` php
<?php 

$w1 = new Workbench(['param', 10], 1);
$w2 = new Workbench(['param', 100], 333);

$b = new Benchmark(['MyClassName', 'myMethod'], $w1, $w2;

$r = $b->startTest()->getResult();

var_dump(
    $r->getBenchmarkResult(0)->getAverageTime(),
    $r->getBenchmarkResult(1)->getAverageTime(),
    $r->getAverageTime()
);
```