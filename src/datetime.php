<?php

/**
 *
 * @param Mixed $datetime
 * @return \DateTime
 */
function datetime($datetime, $timezone = null)
{
    $dependencyInjection = \OngooUtils\OngooUtils::getInstance()->getInjector();
    if ($dependencyInjection && $dependencyInjection->OffsetExists('to_datetime'))
    {
        return $dependencyInjection['to_datetime']($datetime, $timezone);
    }
    return to_datetime($datetime, $timezone);
}

/**
 *
 * @param Mixed $datetime
 * @return \DateTime
 */
function to_datetime($datetime, $timezone = null)
{
    $tz = is_null($timezone) ? null : ($timezone instanceof \DateTimeZone ? $timezone : new \DateTimeZone($timezone));

    if (is_string($datetime))
    {
        return new \DateTime($datetime, $tz);
    } elseif ($datetime instanceof \DateTime)
    {
        return clone $datetime;
    } elseif (is_null($datetime))
    {
        return new \DateTime();
    } else
    {
        throw new \InvalidArgumentException('$datetime must be a date/time string or a \DateTime');
    }
}

/**
 * Return the "now" DateTime, it could be overrided by overidding $injector['now']
 * @return \DateTime
 */
function now()
{
    $dependencyInjection = \OngooUtils\OngooUtils::getInstance()->getInjector();
    if ($dependencyInjection && $dependencyInjection->OffsetExists('now'))
    {
        return $dependencyInjection['now']();
    }
    return new \DateTime();
}

/**
 *
 * @param Mixed $dateinterval
 * @return \DateInterval
 */
function dateinterval($dateinterval, $timezone = null)
{
    $dependencyInjection = \OngooUtils\OngooUtils::getInstance()->getInjector();
    if ($dependencyInjection && $dependencyInjection->OffsetExists('to_dateinterval'))
    {
        return $dependencyInjection['to_dateinterval']($dateinterval, $timezone);
    }
    return to_dateinterval($dateinterval, $timezone);
}

/**
 *
 * @param Mixed $dateinterval
 * @return \DateInterval
 */
function to_dateinterval($dateinterval, $timezone = null)
{
    $tz = is_null($timezone) ? null : ($timezone instanceof \DateTimeZone ? $timezone : new \DateTimeZone($timezone));

    if ($dateinterval instanceof \DateInterval)
    {
        return clone $dateinterval;
    }

    if (is_string($dateinterval) && preg_match("/^P/", $dateinterval))
    {
        return new \DateInterval($dateinterval);
    }

    if (is_string($dateinterval) && preg_match("/(?:([0-9]+) years? ?)?(?:([0-9]+) mons? ?)?(?:([0-9]+) days? ?)?(?:([0-9]{1,2}):([0-9]{1,2}):([0-9]+))?/", $dateinterval, $matchs))
    {
        return \DateInterval::createFromDateString(
                        sprintf("%d years %d months %d days %d hours %d minutes %d seconds", array_key_exists(1, $matchs) ? (is_null($matchs[1]) ? 0 : (int) $matchs[1]) : 0, array_key_exists(2, $matchs) ? (is_null($matchs[2]) ? 0 : (int) $matchs[2]) : 0, array_key_exists(3, $matchs) ? (is_null($matchs[3]) ? 0 : (int) $matchs[3]) : 0, array_key_exists(4, $matchs) ? (is_null($matchs[4]) ? 0 : (int) $matchs[4]) : 0, array_key_exists(5, $matchs) ? (is_null($matchs[5]) ? 0 : (int) $matchs[5]) : 0, array_key_exists(6, $matchs) ? (is_null($matchs[6]) ? 0 : (int) $matchs[6]) : 0
        ));
    }
    throw new \InvalidArgumentException('$time must be a string or a \DateInterval');
}
