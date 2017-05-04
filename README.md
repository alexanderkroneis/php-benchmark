# php-benchmark
A simple PHP Benchmark class.

## Example usage
``` php
<?php
$forBenchmark = Benchmark::time(function () {
    for ($i = 0; $i < 100; $i++) {
        //
    }
});

$whileBenchmark = Benchmark::time(function () {
    $i = 0;
    while ($i < 100) {
        $i++;
    }
});

echo $forBenchmark->compare($whileBenchmark);
```

## Function signature
```
$callback    Closure  A function which will be called in Benchmark::time() function.
$iterations  int      Number of iterations of function call.
$avg         bool     Returns average values of memory and time if true, otherwise will return accumulated values.
Benchmark::time(\Closure $callback, int $iterations, bool $avg)
```