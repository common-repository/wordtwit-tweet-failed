<?
/*
Plugin Name: WordTwit Tweet Failed
Plugin URI: http://plugish.com/plugins/wordtwit-error-log
Version: 1.0
Description: Built to allow a more 'Verbose' output of WordTwit errors.
Author: Jerry Wood
Author URI: http://www.plugish.com
Text Domain: wtel
Domain Path: /lang
License: GNU General Public License 2.0 (GPL) http://www.gnu.org/licenses/gpl.html

# This code is licensed under the GNU License after WordTwit Pro went open source in 2013
# and I realize that using php classes is quite over kill for something like this, but it's
# a habbit so why stop now?
*/

include 'class/main.class.php';

load_plugin_textdomain('wtel', false, basename(dirname(__FILE__)). '/lang');

$wtel = new WordTwit_Error_Log();