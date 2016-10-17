<?php
/**
 * ParroTweet: Merge multiple Twitter accounts into one broadcast stream
 *
 * @author Tim Cotten <tim@cotten.io>
 * 
 * Loads user-defined configuration file (config/parrotweet.json) containing
 * account credentials for a subscriber and broadcaster. Two different accounts 
 * are used so that a subscriber can directly subscribe to a target friend's 
 * account and see otherwise blocked messages.
 *
 * Launches the app to sync up all friend accounts' latest messages, sorts them
 * by timestamp, and then tweets them from the broadcast account.
 */
namespace ParroTweet;

$base_path = dirname(__FILE__);

// Load configuration
$config_path = $base_path . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'parrotweet.json';
$config = json_decode(file_get_contents($config_path), true);
if (empty($config) || !count($config)) {
    exit();
}

$config['base_path'] = $base_path;

// Override timezone by config
date_default_timezone_set($config['timezone']); // for logging

// Abraham's TwitterOAuth
require_once 'vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

// ParroTweet autoloader
require_once 'autoload.php';
$app = new App($config); // app will auto-verify subscriber and broadcaster credentials

// Execute mirroring if verified and friends set
if ($app->isReady()) {
    Logger::print("Starting mirror sync.");
    $app->sync();
    Logger::print("Done.");
}
