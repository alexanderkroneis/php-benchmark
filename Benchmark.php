<?php
namespace Alexgaal\Benchmark;

class Benchmark
{
    /**
     * Defines the precision of rounding.
     */
    const PRECISION = 6;

    /**
     * @var float
     */
    protected $start;

    /**
     * @var float
     */
    protected $difference;

    /**
     * @var array
     */
    protected $memory = [];

    /**
     * @return Benchmark
     */
    public static function begin()
    {
        $benchmark = new Benchmark();
        $benchmark->start();

        return $benchmark;
    }

    /**
     * @param      $callback
     * @param int  $loops
     * @param bool $avg
     *
     * @return Benchmark
     */
    public static function time($callback, $loops = 1, $avg = false)
    {
        $benchmark = new Benchmark();

        if (!is_callable($callback)) {
            throw new \InvalidArgumentException(__CLASS__ . '::' . __FUNCTION__ . ' requires argument $callback to be callable.');
        }

        $time = 0;
        $memory = [
            'usage' => 0,
            'peak'  => 0
        ];

        for ($i = 0; $i < $loops; $i++)
        {
            $timeLoop = microtime(true);

            $memoryLoop = [
                'usage' => memory_get_usage(),
                'peak'  => memory_get_peak_usage()
            ];

            $callback();

            $memory['usage'] += $memoryLoop['usage'];
            $memory['peak']  += $memoryLoop['peak'];

            $time = $time + (microtime(true) - $timeLoop);
        }

        if ($avg) {
            $benchmark->difference = $time / $loops;
            $benchmark->memory = [
                'usage' => $memory['usage'] / $loops,
                'peak'  => $memory['peak']  / $loops
            ];
        } else {
            $benchmark->difference = $time / $loops;
            $benchmark->memory = [
                'usage' => $memory['usage'] / $loops,
                'peak'  => $memory['peak']  / $loops
            ];
        }

        return $benchmark;
    }

    /**
     * @return Benchmark
     */
    protected function start()
    {
        $this->start = microtime(true);

        return $this;
    }

    /**
     * @return Benchmark
     */
    protected function stop()
    {
        $this->difference = microtime(true) - $this->start;

        return $this;
    }

    /**
     * @return float
     */
    protected function getDifference()
    {
        return $this->difference;
    }

    /**
     * @return float
     */
    public function getMicros()
    {
        return $this->getDifference() * 1000000;
    }

    /**
     * @return float
     */
    public function getMillis()
    {
        return $this->getDifference() * 1000;
    }

    /**
     * @return float
     */
    public function getSeconds()
    {
        return $this->getDifference();
    }

    /**
     * @return float
     */
    public function getMinutes()
    {
        return $this->getDifference() / 60;
    }

    /**
     * @param Benchmark $benchmark
     *
     * @return BenchmarkComparison
     */
    public function compare(Benchmark $benchmark)
    {
        return new BenchmarkComparison([$this, $benchmark]);
    }

    public function __toString()
    {
        return '<pre>' . print_r($this, true) . '</pre>';
    }
}
