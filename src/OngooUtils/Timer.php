<?php

namespace OngooUtils;

class Timer
{

    protected $startAt = null;
    protected $state = 'stopped';
    protected $counter = 0;
    protected $totalActiveTime = 0;
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
            $this->activeTime = $this->elapsed();
            $this->totalActiveTime += $this->activeTime;
        }
        return $this->totalActiveTime;
    }

    public function elapsed()
    {
        return $this->now() - $this->startAt;
    }

    public function totalActiveTime()
    {
        if( !$this->isStopped() ) {
            return $this->totalActiveTime + $this->elapsed();
        }
        return $this->totalActiveTime;
    }
    
    public function activeTime()
    {
        if (is_null($this->activeTime))
        {
            return $this->elapsed();
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

        return $this->totalActiveTime() / $this->count();
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
