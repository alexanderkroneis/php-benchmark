<?php

/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 08.05.17
 * Time: 14:22
 */
class WorkbenchResult
{
    protected $results = [];

    protected $iterations = 0;

    public function __construct(array $results)
    {
        $length = count($results);

        for ($i = 0; $i < $length; $i += 2) {
            $this->results[] = [
                'start' => $results[$i],
                'end' => $results[$i+1]
            ];
        }

        $this->iterations = $length / 2;
    }

    public function getAverageTime()
    {
        $times = array_map(function($item) {
            return $item['end']['timestamp'] - $item['start']['timestamp'];
        }, $this->results);

        return array_sum($times) / $this->iterations;
    }
}