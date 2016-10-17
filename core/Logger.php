<?php
namespace ParroTweet;

class Logger
{
    public static function print($msg, $indent=0)
    {
        $timestamp = date(DATE_RFC2822);
        $indentation = str_repeat(' ', $indent+1);

	$output = "[{$timestamp}]{$indentation}{$msg}\n";
        echo $output;
    }
}
