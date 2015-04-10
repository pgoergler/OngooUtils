<?php

namespace OngooUtils;

class Timer
{

    protected $startAt = null;
    protected $state = 'stopped';
    protected $counter = 0;
    protected $elapsed = 0;
    protected $activeTime = null;

    public function start()
    {
        if ($this->isStopped())
        {
            $this->state = 'running';
            $this->startAt = $this->now();
            $this->activeTime = null;
        }
    }

    public function stop()
    {
        if (!$this->isStopped())
        {
            $this->state = 'stopped';
            $this->counter++;
            $this->elapsed += $this->activeTime();
        }
        return $this->elapsed;
    }

    public function elapsed()
    {
        return $this->elapsed;
    }

    public function activeTime()
    {
        if (is_null($this->activeTime))
        {
            $this->activeTime = $this->now() - $this->startAt;
        }
        return $this->activeTime;
    }

    public function count()
    {
        return $this->counter;
    }

    public function average()
    {
        if ($this->counter == 0)
        {
            return 0;
        }

        return $this->elapsed() / $this->count();
    }

    public function isStopped()
    {
        return $this->state == 'stopped';
    }

    private function now()
    {
        return microtime(true) * 1000;
    }

}
