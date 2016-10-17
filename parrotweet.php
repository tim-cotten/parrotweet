<?php
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
