<?php

/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 08.05.17
 * Time: 14:24
 */
class BenchmarkResult
{
    protected $benchmarkResults = [];

    protected $benchmarks = 0;

    public function __construct(array $benchmarkResults)
    {
        $this->benchmarkResults = $benchmarkResults;
        $this->benchmarks = count($benchmarkResults);
    }

    public function getBenchmarkResult(int $number)
    {
        if(array_key_exists($number, $this->benchmarkResults)) {
            return $this->benchmarkResults[$number];
        }

        return false;
    }

    public function getAverageTime()
    {
        $times = array_map(function($item) {
            return $item->getAverageTime();
        }, $this->benchmarkResults);

        return array_sum($times) / $this->benchmarks;
    }
}