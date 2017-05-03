<?php

namespace Alexgaal\Benchmark;

class BenchmarkComparison
{
    /**
     * @var array
     */
    protected $benchmarks = [];

    /**
     * @var array
     */
    protected $comparison = [];

    /**
     * BenchmarkComparison constructor.
     *
     * @param array $benchmarks
     *
     * @throws \Exception
     */
    function __construct(array $benchmarks)
    {
        if (count($benchmarks) === 0 || count($benchmarks) > 2) {
            throw new \Exception("Cannot handle more than two Benchmarks.");
        }
        
        $this->benchmarks = $benchmarks;
        $this->compare();

        return $this;
    }

    /**
     * @return BenchmarkComparison
     */
    protected function compare()
    {
        $benchmarks = $this->benchmarks;

        $this->comparison = [
            'micros' => $benchmarks[0]->getMicros() - $benchmarks[1]->getMicros(),
            'millis' => $benchmarks[0]->getMillis() - $benchmarks[1]->getMillis(),
            'seconds' => $benchmarks[0]->getSeconds() - $benchmarks[1]->getSeconds(),
            'minutes' => $benchmarks[0]->getMinutes() - $benchmarks[1]->getMinutes(),
            'factor' => $benchmarks[0]->getMillis() / $benchmarks[1]->getMillis()
        ];

        return $this;
    }

    /**
     * @return float
     */
    public function getMicros()
    {
        return $this->comparison['micros'];
    }

    /**
     * @return float
     */
    public function getMillis()
    {
        return $this->comparison['millis'];
    }

    /**
     * @return float
     */
    public function getSeconds()
    {
        return $this->comparison['seconds'];
    }

    /**
     * @return float
     */
    public function getMinutes()
    {
        return $this->comparison['minutes'];
    }

    /**
     * @return float
     */
    public function getFactor()
    {
        return $this->comparison['factor'];
    }

    public function __toString()
    {
        return '<pre>' . print_r($this, true) . '</pre>';
    }
}
