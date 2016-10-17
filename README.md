<span itemprop="name">ParroTweet</span>
------------
<p itemprop="description">Merge multiple Twitter accounts into one broadcast stream.</p>
<p>Inspired by the work of Richard Vardit in defeating the censorship of the Kirchner presidency in Argentina.</p>
<p>ParroTweet allows you to follow your friends with one account (which can see even blocked messages), while reposting all the content into a single stream on a separate account for journalistic or historical purposes. A similar technology was leveraged by @hosepink to mirror @CFKArgentina's account from 2014-2015. You can learn more about Richard Vardit's story in the Autumn 2016 edition of 2600.</p>
<p><em>Version: 0.1.0 <strong>beta</strong></em></p>

## Examples
<ul>
<li>US Congress: https://twitter.com/PT_US_Congress</li>
<li>US Presidential Election 2016: https://twitter.com/PT_US_Prez2016</li>
</ul>

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
