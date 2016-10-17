<?php
/**
 * ParroTweet\Logger
 *
 * @author Tim Cotten <tim@cotten.io>
 *
 * Simple logger (stdout) that auto-timestamps entries in RFC 2822 format.
 *
 * Includes optional indentation.
 */
namespace ParroTweet;

class Logger
{
    /**
     * Logger constructor
     *
     * @var string $msg Text will pre-pended with timestamp, appended with newline
     * @var int $indent Number of spaces to indent $msg to the right of timestamp
     */
    public static function print($msg, $indent=0)
    {
        $timestamp = date(DATE_RFC2822);
        $indentation = str_repeat(' ', $indent+1);

	echo "[{$timestamp}]{$indentation}{$msg}\n";
    }
}
