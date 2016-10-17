<?php
namespace ParroTweet;

class Parro
{
    public $friend_id;
    public $tweet_id;
    public $text;
    public $timestamp;

    public function __construct($friend_id, $tweet_id, $text, $timestamp)
    {
        $this->friend_id = $friend_id;
        $this->tweet_id = $tweet_id;
        $this->text = $text;
        $this->timestamp = $timestamp;
    }
}
