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
