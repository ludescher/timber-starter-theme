<?php

namespace lib\Workers;

use lib\Annotation\Worker;

interface WorkerInterface {
    /**
     * Does the work
     *
     * @return NULL
     */
    public function work();
}