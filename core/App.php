<?php
namespace ParroTweet;
use Abraham\TwitterOAuth\TwitterOAuth;

class App
{
    const SUBSCRIBER =  0;
    const BROADCASTER = 1;

    private $_connSubscriber  = null;
    private $_connBroadcaster = null;
    private $_friends = array();
    private $_base_path;
    private $_ready = false;
    

    public function __construct($config)
    {
        $this->_connSubscriber = new TwitterOAuth($config['subscriber_key'], $config['subscriber_secret'], $config['subscriber_token'], $config['subscriber_token_secret']);
        $this->_connBroadcaster = new TwitterOAuth($config['broadcaster_key'], $config['broadcaster_secret'], $config['broadcaster_token'], $config['broadcaster_token_secret']);
        $this->_friends = $config['friends'];
        $this->_base_path = $config['base_path'];

        $this->_ready = $this->verify(self::SUBSCRIBER) && 
                        $this->verify(self::BROADCASTER) && 
                        count($this->_friends);
    }

    public function verify($connection_type)
    {
        $response = null;

        switch ($connection_type) {
            case self::SUBSCRIBER:  $response = $this->_connSubscriber->get('account/verify_credentials'); break;
            case self::BROADCASTER: $response = $this->_connBroadcaster->get('account/verify_credentials'); break;
        }

        return (!empty($response) && !isset($response->errors));
    }

    public function isReady()
    {
        return $this->_ready;
    }

    public function sync()
    {
        $parros = $this->_getLatest();
        foreach ($parros as $p) {
            $this->_broadcast($p);
        }
    }

    public function _broadcast($parro)
    {
        if (empty($parro)) {
            return;
        }

        $status_path = $this->_base_path . DIRECTORY_SEPARATOR . 'status';
        $path = $status_path . DIRECTORY_SEPARATOR . $parro->friend_id;
        
        try {
            $result = $this->_connBroadcaster->post('statuses/update', array('status' => $parro->text));
            file_put_contents($path, (string)$parro->tweet_id);
            Logger::print("Published: [{$parro->friend_id}:{$parro->tweet_id}] {$parro->text}", 1);
        } catch (Exception $e) {
            print_r($e);
        }
    }

    private function _getLatest()
    {
        // Create a status folder if it doesn't exist
        $status_path = $this->_base_path . DIRECTORY_SEPARATOR . 'status';
        if (!file_exists($status_path)) {
            mkdir($status_path, 0755, true);
        }

        // Compile a list of parro-tweets
        $parros = array();
        foreach ($this->_friends as $friend_id) {
            // Get latest known tweet, or create stat file if unknown
            $last_tweet_id = 0;
            $path = $status_path . DIRECTORY_SEPARATOR . $friend_id;
            if (file_exists($path)) {
                $last_tweet_id = file_get_contents($path);
            } else {
                file_put_contents($path, $last_tweet_id);
            }

            // Set search parameters for friend
            $params = array();
            $params['user_id'] = $friend_id;
            $params['exclude_replies'] = true;
            $params['includes_rts'] = false;
            $params['count'] = ($last_tweet_id != 0) ? 200 : 1;
            if ($params['count'] > 1) {
                $params['since_id'] = $last_tweet_id;
            }

            Logger::print("Fetching Friend {$friend_id} since {$last_tweet_id}");

            $content = $this->_connSubscriber->get('statuses/user_timeline', $params);

            if (isset($content->errors)) {
                print_r($content);
                continue;
            }


            $tweets = (array)$content;
            foreach ($tweets as $t) {
               $dt = new \DateTime($t->created_at);
               $timestamp = $dt->format('U');
               $text = html_entity_decode($t->text);
               $text = mb_substr($text, 0, 140); // Truncate if invalid chars overfilled
               $key = "{$timestamp}_{$friend_id}_{$t->id_str}";

               $parros[$key] = new Parro($friend_id, $t->id_str, $text, $timestamp);
            }
        }

        ksort($parros);

        return $parros;
    }
}
