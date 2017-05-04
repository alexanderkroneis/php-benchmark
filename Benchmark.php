<?php
namespace Alexgaal\Benchmark;

/**
 * Copyright (c) 2017 <copyright holders>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of
 * the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO
 * THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * @author  Alexander Gaal
 * @license MIT
 * @version 1
 * @package Alexgaal\Benchmark
 *
 * @example
 * $usingFunctionBenchmark = Benchmark::time(function () {
 *     pow(2, 2);
 * }, 10000, true);
 *
 * $multiplyBenchmark = Benchmark::time(function () {
 *     2 * 2;
 * }, 10000, true);
 *
 * echo $usingFunctionBenchmark->compare($multiplyBenchmark);
 */
class Benchmark
{
    /**
     * Defines the precision of rounding.
     */
    const PRECISION = 6;

    /**
     * @var float
     */
    protected $startTime = 0;

    /**
     * @var float
     */
    protected $difference = 0;

    /**
     * @var array
     */
    protected $memory = [];

    /**
     * Stores information about loops while benchmarking.
     *
     * @var BenchmarkResult[]
     */
    protected $results = [];

    /**
     * @return Benchmark
     */
    public static function begin()
    {
        $benchmark = new Benchmark();
        $benchmark->startTime = microtime(true);
        $benchmark->memory    = [
            'usage' => memory_get_usage(),
            'peak'  => memory_get_peak_usage()
        ];

        return $benchmark;
    }

    /**
     * @return Benchmark
     */
    public function stop()
    {
        $benchmarkResult = new BenchmarkResult();
        $benchmarkResult->setTime(microtime(true) - $this->startTime);
        $benchmarkResult->setMemory([
            'usage' => memory_get_usage()      - $this->memory['usage'],
            'peak'  => memory_get_peak_usage() - $this->memory['peak']
        ]);

        $this->results[] = $benchmarkResult;

        return $this;
    }


    /**
     * Measures the running time and used memory of an callback function.
     *
     * @param       $callback
     * @param array $params
     * @param int   $iterations
     * @param bool  $avg
     *
     * @return Benchmark
     */
    public static function time($callback, $params = [], $iterations = 1, $avg = false)
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException(__CLASS__ . '::' . __FUNCTION__ . ' requires argument $callback to be callable.');
        }

        $benchmark = new Benchmark();

        for ($i = 0; $i < $iterations; $i++)
        {
            $benchmarkResult = new BenchmarkResult();

            $memoryLoopStart = [
                'usage' => memory_get_usage(),
                'peak'  => memory_get_peak_usage()
            ];
            $timeStart = microtime(true);

            call_user_func($callback, $params);

            $benchmarkResult->setTime(microtime(true) - $timeStart);
            $benchmarkResult->setMemory([
                'usage' => memory_get_usage()      - $memoryLoopStart['usage'],
                'peak'  => memory_get_peak_usage() - $memoryLoopStart['peak']
            ]);

            $benchmark->results[] = $benchmarkResult;
        }

        $benchmark->difference($avg);
        $benchmark->memory($avg);

        return $benchmark;
    }

    /**
     * @param bool $avg
     */
    protected function difference($avg = false)
    {
        $this->difference = 0;

        foreach ($this->results as $result)
        {
            $this->difference += $result->getTime();
        }

        if ($avg)
        {
            $this->difference /= count($this->results);
        }
    }

    /**
     * @param bool $avg
     */
    protected function memory($avg = false)
    {
        $this->memory = [
            'usage' => 0,
            'peak'  => 0
        ];

        foreach ($this->results as $result)
        {
            $resultMemory = $result->getMemory();

            $this->memory['usage'] += $resultMemory['usage'];
            $this->memory['peak']  += $resultMemory['peak'];
        }

        if ($avg)
        {
            $this->memory['usage'] /= count($this->results);
            $this->memory['peak']  /= count($this->results);
        }
    }

    /**
     * Returns the difference from start until end of benchmark in seconds as float.
     *
     * @return float
     */
    protected function getDifference()
    {
        return $this->difference;
    }

    /**
     * Returns microseconds of benchmark.
     *
     * @return float
     */
    public function getMicros()
    {
        return $this->getDifference() * 1000000;
    }

    /**
     * Returns milliseconds of benchmark.
     *
     * @return float
     */
    public function getMillis()
    {
        return $this->getDifference() * 1000;
    }

    /**
     * Returns seconds of benchmark.
     *
     * @return float
     */
    public function getSeconds()
    {
        return $this->getDifference();
    }

    /**
     * Returns minutes of benchmark.
     *
     * @return float
     */
    public function getMinutes()
    {
        return $this->getDifference() / 60;
    }

    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * Compares this benchmark with another given benchmark.
     *
     * @param Benchmark $benchmark
     *
     * @return BenchmarkComparison
     */
    public function compare(Benchmark $benchmark)
    {
        return new BenchmarkComparison([$this, $benchmark]);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '<pre>' . print_r($this, true) . '</pre>';
    }
}
