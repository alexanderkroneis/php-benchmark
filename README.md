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

``` php
<?php
Benchmark::begin();
// do some stuff
$benchmark = Benchmark::stop();
echo $benchmark;
```
