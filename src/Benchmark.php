<?php

/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 08.05.17
 * Time: 14:23
 */
class Benchmark
{
    protected $callable = null;

    protected $workbenches = [];

    protected $workbenchResults = [];

    public function __construct(callable $workpiece, Workbench ...$workbenches)
    {
        $this->callable = $workpiece;
        $this->workbenches = $workbenches;
    }

    public function startTest()
    {
        foreach ($this->workbenches as $workbench) {
            $this->workbenchResults[] = $workbench->startTest($this->callable)->getResult();
        }

        return $this;
    }

    public function getResult()
    {
        return new BenchmarkResult($this->workbenchResults);
    }
}