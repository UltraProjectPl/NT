<?php
declare(strict_types=1);

namespace App;

class Perceptron
{
    /**
     * @var float
     */
    private $eta;

    /**
     * @var int
     */
    private $numberIteration;

    /**
     * @var array
     */
    private $weights = [];

    /**
     * @var array
     */
    private $errors = [];


    public function __construct(float $eta = 0.1, int $numberIteration = 10)
    {
        $this->eta = $eta;
        $this->numberIteration = $numberIteration;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function fit(array $X, array $y): self
    {
        $this->weights = array_fill(0, count($X[1]) + 1, 0);

        for($i = 0; $i < $this->numberIteration; $i++) {
//            dump($this->weights);
            $errors = 0;

            foreach (array_map(null, $X, $y) as [$xi, $target]) {
                $update = $this->eta * ($target - $this->predict($xi));
                for ($j = 1; $j < count($this->weights); $j++) {
                    $this->weights[$j] += $xi[$j - 1] * $update;
                }
                $this->weights[0] += $update;
                $errors += $update !== 0.0;
            }

            $this->errors[] = $errors;
        }

        return $this;
    }

    public function predict(array $X): int
    {
        return $this->networkInput($X) >= 0 ? 1 : -1;
    }

    private function networkInput(array $X): float
    {
        return array_sum(array_map(static function(float $i, float $j) {
            return $i * $j;
        }, $X, array_slice($this->weights, 1, count($this->weights)))) + $this->weights[0];
    }
}