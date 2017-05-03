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

## Result
```
Alexgaal\Benchmark\BenchmarkComparison Object
(
    [benchmarks:protected] => Array
        (
            [0] => Alexgaal\Benchmark\Benchmark Object
                (
                    [start:protected] => 
                    [difference:protected] => 3.1232357025146E-6
                    [memory:protected] => Array
                        (
                            [usage] => 365064
                            [peak] => 402968
                        )

                )

            [1] => Alexgaal\Benchmark\Benchmark Object
                (
                    [start:protected] => 
                    [difference:protected] => 1.9301652908325E-6
                    [memory:protected] => Array
                        (
                            [usage] => 365416
                            [peak] => 402968
                        )

                )

        )

    [comparison:protected] => Array
        (
            [micros] => 1.1930704116821
            [millis] => 0.0011930704116821
            [seconds] => 1.1930704116821E-6
            [minutes] => 1.9884506861369E-8
            [factor] => 1.618118260311
        )

)
```
