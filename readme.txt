=== Advanced Dewplayer ===
Contributors: westerndeal
Tags: wordpress dewplayer, audio, audio player, mp3, mp3 player, flash, flash player, dewplayer, wp dewplayer, music, music player, ultimate player, songs
Requires at least: 2.0.2
Tested up to: 3.5.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Get all MP3 files from any directory and show them beautifully with player and other options.

== Description ==

Upload MP3 files to any folder on your server. Add the shortcode to your page/post with path of your MP3 folder from which you want to fetch all MP3 files and you have a beautiful playable list of MP3's with much more options.

If you want to display only single MP3 file then give full path of that MP3 file from local or remote server.

**How to Use :**

*For directory fetching:*
Copy below shortcode into your page/post
[musicdirectory path="Path of folder from which you want to get all MP3 files"]. 
**Remember:** Don't forget to Include trailing slash (/) at the end of path and use relative path.

*Examples:*
[musicdirectory path="playlist/] 

*For Single MP3 fetching:*
Copy below shortcode into your page/post
[musicsingle file="Full path of MP3 file"].
You can use local as well as remote MP3 file path

*Examples:*
[musicsingle file="http://www.mymusic.com/playlist/audio.mp3"]

**Remember:** Use full path only.

== Installation ==

1. Download plugin and unzip.
2. Upload the plugin file to your WordPress plugins directory inside of wp-content : /wp-content/plugins/
3. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= What to do if encounter warning: filesize() stat failed ? =

Please make sure that directory path you enter for MP3 files fetching has trailing slash (i.e. '/') at the end.

= How to use this plugin shortcode in template files ? =

use following code for inserting shortcode into template file:

`<?php 
echo do_shortcode("[musicdirectory path="playlist/"]"); //replace playlist with your path 
?>`

== Screenshots ==

1. Plugin Settings
2. Front-end look

== Changelog ==

= 1.0.0 =
* initial release