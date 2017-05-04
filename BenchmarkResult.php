<?php
namespace Alexgaal\Benchmark;

/**
 * Class BenchmarkResult
 * @package Alexgaal\Benchmark
 */
class BenchmarkResult
{
    /**
     * @var array
     */
    protected $memory = [];

    /**
     * @var float
     */
    protected $time   = 0;

    /**
     * BenchmarkResult constructor.
     *
     * @param array $memory
     * @param float $time
     */
    function __construct($memory = null, $time = null)
    {
        if (null !== $memory)
        {
            $this->memory = $memory;
        }

        if (null !== $time)
        {
            $this->time = $time;
        }
    }

    /**
     * @return float
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param float $time
     */
    public function setTime(float $time)
    {
        $this->time = $time;
    }

    /**
     * @return array|null
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * @param array $memory
     */
    public function setMemory(array $memory)
    {
        $this->memory = $memory;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return (string) ('<pre>' . print_r($this, true) . '</pre>');
    }
}