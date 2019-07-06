<?php

namespace src\Controller;

use lib\Annotation\Worker;
use lib\Workers\WorkerInterface;

/**
 * Class SlowWorker
 *
 * @Worker(
 *     name = "Slow Worker",
 *     speed = 5
 * )
 */
class SlowWorker implements WorkerInterface
{

    /**
     * {@inheritdoc}
     */
    public function work()
    {
        return 'I work really slowly';
    }
}