<?php

include __DIR__ . '/../src/Benchmark.php';
include __DIR__ . '/../src/BenchmarkResult.php';
include __DIR__ . '/../src/Workbench.php';
include __DIR__ . '/../src/WorkbenchResult.php';

$f = function ($param) {
    return $param * 100;
};

class Test {
    public function tester($p1) {
        return $p1 * 100;
    }
}

$w1 = new Workbench([100], 100);

$b1 = new Benchmark($f, $w1);
$b2 = new Benchmark(['Test', 'tester'], $w1);

$r1 = $b1->startTest()->getResult();
$r2 = $b1->startTest()->getResult();

var_dump(
    $r1->getBenchmarkResult(0)->getAverageTime(),
    $r1->getAverageTime(),
    $r2->getBenchmarkResult(0)->getAverageTime(),
    $r2->getAverageTime()
);