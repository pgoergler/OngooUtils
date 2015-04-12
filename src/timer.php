<?php

function timer_start($timer_id = 'main')
{
    $timer = \OngooUtils\TimerManager::getInstance()->getTimer($timer_id);
    return $timer->start();
}

/**
 * Return the running time  since last start()
 * 
 * @param string $timer_id
 * @return float nb seconds,milliseconds
 */
function timer_stop($timer_id = 'main')
{
    $timer = \OngooUtils\TimerManager::getInstance()->getTimer($timer_id);
    return $timer->stop();
}

function timer_count($timer_id = 'main')
{
    $timer = \OngooUtils\TimerManager::getInstance()->getTimer($timer_id);
    return $timer->count();
}

/**
 * Return the running time since last start()
 * 
 * @param string $timer_id
 * @return float nb seconds,milliseconds
 */
function timer_elapsed($timer_id = 'main')
{
    $timer = \OngooUtils\TimerManager::getInstance()->getTimer($timer_id);
    return $timer->elapsed();
}

/**
 * Return the sum of active time (sum of time between start and stop)
 * 
 * @param string $timer_id
 * @return float nb seconds,milliseconds
 */
function timer_total_active_time($timer_id = 'main')
{
    $timer = \OngooUtils\TimerManager::getInstance()->getTimer($timer_id);
    return $timer->totalActiveTime();
}

/**
 * Return last active time
 * 
 * @param string $timer_id
 * @return float nb seconds,milliseconds
 */
function timer_active_time($timer_id = 'main')
{
    $timer = \OngooUtils\TimerManager::getInstance()->getTimer($timer_id);
    return $timer->activeTime();
}

/**
 * 
 * @param string $timer_id
 * @return \OngooUtils\Timer
 */
function timer_get($timer_id = 'main')
{
    return \OngooUtils\TimerManager::getInstance()->getTimer($timer_id);
}

/**
 * Return the average of active time (sum of time between start and stop)
 * 
 * @param string $timer_id
 * @return float nb seconds,milliseconds
 */
function timer_average($timer_id = 'main')
{
    $timer = \OngooUtils\TimerManager::getInstance()->getTimer($timer_id);
    return $timer->average();
}

function timer_log($timer_id = 'main', $prefix = '')
{
    $manager = \OngooUtils\TimerManager::getInstance();
    $timer = $manager->getTimer($timer_id);

    $elapsed = \round($timer->elapsed(), 2, PHP_ROUND_HALF_UP);
    $counter = $timer->count();
    $avg = \round($timer->average(), 2, PHP_ROUND_HALF_UP);

    $manager->log("execution time for {$prefix}#{$timer_id} elapsed: {$elapsed}ms for {$counter}calls (avg: {$avg}ms/call)");
}
