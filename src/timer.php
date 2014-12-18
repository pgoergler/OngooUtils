<?php

function timer_start($timer_id = 'main')
{
    $timer = \OngooUtils\TimerManager::getInstance()->getTimer($timer_id);
    return $timer->start();
}

function timer_stop($timer_id = 'main')
{
    $timer = \OngooUtils\TimerManager::getInstance()->getTimer($timer_id);
    return $timer->stop();
}

function timer_counter($timer_id = 'main')
{
    $timer = \OngooUtils\TimerManager::getInstance()->getTimer($timer_id);
    return $timer->counter();
}

function timer_elapsed($timer_id = 'main')
{
    $timer = \OngooUtils\TimerManager::getInstance()->getTimer($timer_id);
    return $timer->elapsed();
}

function timer_get($timer_id = 'main')
{
    $timer = \OngooUtils\TimerManager::getInstance()->getTimer($timer_id);
    return $timer->get();
}

function timer_log($timer_id = 'main', $prefix = '')
{
    $manager = \OngooUtils\TimerManager::getInstance();
    $timer = $manager->getTimer($timer_id);

    $elapsed = \round($timer->elapsed() * 1000, 2, PHP_ROUND_HALF_UP);
    $counter = $timer->counter();
    $total_time = \round($timer->get() * 1000, 2, PHP_ROUND_HALF_UP);
    $avg = \round($counter > 0 ? $elapsed / $counter : 0, 2, PHP_ROUND_HALF_UP);
    $manager->log("execution time for {$prefix}#{$timer_id} elapsed: {$elapsed}ms for {$counter}calls (avg: {$avg}/call), time total: {$total_time}ms");
}
