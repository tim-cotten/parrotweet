<?php
/**
 * ParroTweet\Parro
 *
 * @author Tim Cotten <tim@cotten.io>
 *
 * Simple class to hold 'Parro' data. A 'Parro' is a tweet and its
 * contextual data needed to properly sort in a broadcast stream.
 */
namespace ParroTweet;

class Parro
{
    public $friend_id;
    public $tweet_id;
    public $text;
    public $timestamp;

    /**
     * Parro constructor
     *
     * @var string $friend_id Numeric ID of target friend
     * @var string $tweet_id  Numeric ID of friend's tweet
     * @var string $text      Text is multi-byte, HTML decoded
     * @var int $timestamp    UNIX Epoch timestamp
     */
    public function __construct($friend_id, $tweet_id, $text, $timestamp)
    {
        $this->friend_id = $friend_id;
        $this->tweet_id = $tweet_id;
        $this->text = $text;
        $this->timestamp = $timestamp;
    }
}
