<span itemprop="name">ParroTweet</span>
------------
<p itemprop="description">Merge multiple Twitter accounts into one broadcast stream.</p>
<p>Inspired by the work of Richard Vardit in defeating the censorship of the Kirchner presidency in Argentina.</p>
<p><em>Version: 0.1.0 <strong>beta</strong></em></p>

## Requirements
<ul>
<li>PHP 5.6 or greater</li>
<li>Composer</li>
</ul>

## Dependecies
<ul>
<li>TwitterOAuth (https://github.com/abraham/twitteroauth)</li>
</ul>

## Installation
<ol>
<li>`composer install`</li>
<li>`cp config/parrotweet.json.default config/parrotweet.json`</li>
<li>Edit the config/parrotweet.json file with subscriber/broadcaster account credentials and friends list</li>
</ol>

## Run
`php parrotweet.php`
