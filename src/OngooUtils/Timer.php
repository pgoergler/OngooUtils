<?php

namespace OngooUtils;

class Timer
{

    protected $resetAt;
    protected $startAt;
    protected $elapsed = 0;
    protected $counter = 0;
    protected $state = 'stopped';

    public function __construct()
    {
        $this->reset();
    }

    public function reset()
    {
        $this->resetAt = $this->now();
        $this->startAt = 0;
        $this->elapsed = 0;
        $this->counter = 0;
        $this->state = 'stopped';
    }

    public function start()
    {
        if (!$this->isStopped())
        {
            $this->stop();
        }
        $this->startAt = $this->now();
        $this->state = 'running';
        return $this;
    }

    public function stop()
    {
        if ($this->isStopped())
        {
            return $this;
        }
        $now = $this->now();
        $this->elapsed += $now - $this->startAt;
        $this->counter++;
        $this->state = 'stopped';
        return $this;
    }

    public function isStopped()
    {
        return $this->state == 'stopped';
    }

    public function elapsed()
    {
        if (!$this->isStopped())
        {
            $this->stop();
        }
        return $this->elapsed;
    }

    public function counter()
    {
        if (!$this->isStopped())
        {
            $this->stop();
        }
        return $this->counter;
    }

    public function get()
    {
        return $this->now() - $this->resetAt;
    }

    private function now()
    {
        return microtime(true);
    }

}


