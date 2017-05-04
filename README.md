# php-benchmark
A simple PHP Benchmark class.

## Example usage
### Benchmark a function
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

### Benchmark a block of code
``` php
<?php
$forBenchmark = Benchmark::begin();
for ($i = 0; $i < 100; $i++) {
    //
}
$forBenchmark->stop();

$whileBenchmark = Benchmark::begin();
$i = 0;
while ($i < 100) {
    $i++;
}
$whileBenchmark->stop();

echo $forBenchmark->compare($whileBenchmark);
```

### Nested benchmarks
``` php
<?php
$calculateBenchmark = Benchmark::begin();
for ($i = 0; $i < 1000; $i++) {
    pow($i, $i);
}

$databaseBenchmark = Benchmark::begin();
// do some random database stuff
$databaseBenchmark->stop();
$calculateBenchmark->stop();
```


## Function signature
```
$callback    Closure  A function which will be called in Benchmark::time() function.
$iterations  int      Number of iterations of function call.
$avg         bool     Returns average values of memory and time if true, otherwise will return accumulated values.
Benchmark::time(\Closure $callback, int $iterations, bool $avg)
```