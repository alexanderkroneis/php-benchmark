<?php

/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 08.05.17
 * Time: 14:22
 */
class Workbench
{
    protected $params = [];

    protected $iterations = 1;

    protected $snapshots = [];

    public function __construct(array $params = [], $iterations = 1)
    {
        $this->params = $params;
        $this->iterations = $iterations;
    }

    public function startTest(callable $workpiece)
    {
        for ($i = 0; $i < $this->iterations; $i++) {
            $this->snapshot();
            call_user_func_array($workpiece, $this->params);
            $this->snapshot();
        }

        return $this;
    }

    public function getResult()
    {
        return new WorkbenchResult($this->snapshots);
    }

    protected function snapshot()
    {
        $this->snapshots[] = [
            'timestamp' => microtime(true),
        ];
    }
}