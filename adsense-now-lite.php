<?php
/*
Plugin Name: AdSense Now! Lite
Plugin URI: http://www.thulasidas.com/adsense
Description: Get started with AdSense now, and make money from your blog. Configure it at <a href="options-general.php?page=adsense-now-lite.php">Settings &rarr; AdSense Now! Lite</a>.
Version: 3.01
Author: Manoj Thulasidas
Author URI: http://www.thulasidas.com
*/

/*
Copyright (C) 2008 www.thulasidas.com

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if (!class_exists("adsNow")) {
  class adsNow {
    var $plugindir, $locale, $defaults, $adminOptions, $adminOptionName, $mcAd;
    function adsNow() { //constructor
      if (file_exists (dirname (__FILE__).'/defaults.php')){
        include (dirname (__FILE__).'/defaults.php');
        $this->defaults = $defaults ;
      }
      if (empty($this->defaults))  {
        add_action('admin_notices', create_function('', 'if (substr( $_SERVER["PHP_SELF"], -11 ) == "plugins.php"|| $_GET["page"] == "adsense-now-lite.php") echo \'<div class="error"><p><b><em>AdSense Now!</em></b>: Error locating or loading the defaults! Ensure <code>defaults.php</code> exists, or reinstall the plugin.</p></div>\';')) ;
      }
    }
    function init() {
      $this->getAdminOptions();
    }
    //Returns an array of admin options
    function getAdminOptions($reset = false) {
      if (!$reset && count($this->adminOptions) > 0) {
        return $this->adminOptions ;
      }
      $mThemeName = get_settings('stylesheet') ;
      $mOptions = "adsNow" . $mThemeName ;
      $this->plugindir = get_option('siteurl') . '/' . PLUGINDIR .
        '/' . basename(dirname(__FILE__)) ;
      $locale = get_locale();
      $this->locale = $locale ;
      if(!empty($this->locale) && $this->locale != 'en_US') {
        $moFile = dirname(__FILE__) . '/lang/' . $this->locale . '/easy-adsenser.mo';
        if(@file_exists($moFile) && is_readable($moFile))
          load_textdomain('easy-adsenser', $moFile);
        else {
          // look for any other similar locale with the same first three characters
          $foo = glob(dirname(__FILE__) . '/lang/' . substr($this->locale, 0, 2) .
                      '*/easy-adsenser.mo') ;
          if (!empty($foo)) {
            $moFile = $foo[0] ;
            load_textdomain('easy-adsenser', $moFile);
            $this->locale = basename(dirname($moFile)) ;
          }
        }
      }
      $adsNowAdminOptions =
        array('info' => "<!-- AdSense Now Lite V2.03 -->\n",
          'policy' => 'unknown',
          'ad_text' => $this->defaults['defaultText'],
          'show_leadin' => 'float:right',
          'show_midtext' => 'float:left',
          'show_leadout' => 'float:right',
          'kill_pages' => false,
          'kill_home' => false,
          'kill_attach' => false,
          'kill_front' => false,
          'kill_cat' => false,
          'kill_tag' => false,
          'kill_archive' => false);

      $adNwOptions = get_option($mOptions);
      if (empty($adNwOptions)) {
        // try loading the default from the pre 1.3 version, so as not to annoy
        // the dudes who have already been using adNwsenser
        $adminOptionsName = "adsNowAdminOptions";
        $adNwOptions = get_option($adminOptionsName);
      }
      if (!empty($adNwOptions) && ! $reset) {
        foreach ($adNwOptions as $key => $option)
          $adsNowAdminOptions[$key] = $option;
      }

      update_option($mOptions, $adsNowAdminOptions);
      $this->adminOptions = $adsNowAdminOptions ;
      $this->adminOptionName = $mOptions ;
      return $adsNowAdminOptions;
    }

    function handleDefaultText($text, $key = '300x250') {
      $ret = $text ;
      if ($ret == $this->defaults['defaultText']
        || strlen(trim($ret)) == 0) {
        $x = strpos($key, 'x') ;
        $w = substr($key, 0, $x);
        $h = substr($key, $x+1);
        $p = (int)(min($w,$h)/6) ;
        $ret = '<div style="width:'.$w.'px;height:'.$h.'px;border:1px solid red;"><div style="padding:'.$p.'px;text-align:center;font-family:arial;font-size:8pt;"><p>Your ads will be inserted here by</p><p><b><a href="http://buy.ads-ez.com/adsense-now" title="The simplest and quickest AdSense Plugin for WordPress" target="_blank">AdSense Now! Lite</a></b>.</p><p>Please go to the plugin admin page to paste your ad code.</p></div></div>' ;
      }
      return $ret ;
    }

    //Prints out the admin page
    function printAdminPage() {
      if (empty($this->defaults)) return ;
      $mThemeName = get_settings('stylesheet') ;
      $mOptions = "adsNow" . $mThemeName ;
      $adNwOptions = $this->getAdminOptions();

      if (isset($_POST['update_adsNowSettings'])) {
        if (isset($_POST['ezAdSensePolicy']))
          $adNwOptions['policy'] = $_POST['ezAdSensePolicy'];
        if (isset($_POST['adsNowText'])) {
          $adNwOptions['ad_text'] = $_POST['adsNowText'];
        }
        if (isset($_POST['adsNowShowLeadin'])) {
          $adNwOptions['show_leadin'] = $_POST['adsNowShowLeadin'];
        }
        if (isset($_POST['adsNowShowMidtext'])) {
          $adNwOptions['show_midtext'] = $_POST['adsNowShowMidtext'];
        }
        if (isset($_POST['adsNowShowLeadout'])) {
          $adNwOptions['show_leadout'] = $_POST['adsNowShowLeadout'];
        }
        $adNwOptions['kill_pages'] = $_POST['adNwKillPages'];
        $adNwOptions['kill_home'] = $_POST['adNwKillHome'];
        $adNwOptions['kill_attach'] = $_POST['adNwKillAttach'];
        $adNwOptions['kill_front'] = $_POST['adNwKillFront'];
        $adNwOptions['kill_cat'] = $_POST['adNwKillCat'];
        $adNwOptions['kill_tag'] = $_POST['adNwKillTag'];
        $adNwOptions['kill_archive'] = $_POST['adNwKillArchive'];

        $adNwOptions['info'] = $this->info() ;

        update_option($mOptions, $adNwOptions);

        echo '<div class="updated"><p><strong>';
        _e("Settings Updated.", "easy-adsenser");
        echo '</strong></p> </div>' ;
      }
      else if (isset($_POST['reset_adsNowSettings'])) {
        $reset = true ;
        $adNwOptions = $this->getAdminOptions($reset);
        echo '<div class="updated"><p><strong>' ;
        _e("Ok, all your settings have been discarded!","easy-adsenser");
        echo '</strong></p> </div>' ;
      }
      else if (isset($_POST['clean_db']) || isset($_POST['kill_me'])) {
        $reset = true ;
        $adNwOptions = $this->getAdminOptions($reset);
        $this->cleanDB('adsNow');

        echo '<div class="updated"><p><strong>' ;
        _e("Database has been cleaned. All your options for this plugin (for all themes) have been removed.",
           "easy-adsenser");
        echo '</strong></p> </div>' ;
        if (isset($_POST['kill_me'])) {
          remove_action('admin_menu', 'adsNow_ap') ;
          deactivate_plugins('adsense-now-lite/adsense-now-lite.php', true);

          echo '<div class="updated"><p><strong>' ;
          _e("This plugin has been deactivated.", "easy-adsenser");
          echo '<a href="plugins.php?deactivate=true">' ;
          _e("Refresh", "easy-adsenser") ;
          echo '</a></strong></p></div>' ;

          return;
        }
      }
      if (file_exists (dirname (__FILE__).'/admin.php'))
        include (dirname (__FILE__).'/admin.php');
      else
      echo '<font size="+1" color="red">' .
        __("Error locating the admin page!\nEnsure admin.php exists, or reinstall the plugin.", 'easy-adsenser') .
        '</font>' ;
    }//End function printAdminPage()

    function mc($mc, $ad, $size=false, $key='300x250') {
      return $ad ;
    }

    function info() {
      $me = basename(dirname(__FILE__)) . '/' . basename(__FILE__);
      $plugins = get_plugins() ;
      $str =  "<!-- " . $plugins[$me]['Title'] . " V" . $plugins[$me]['Version'] . " -->\n";
      return $str ;
    }

    var $nwMax = 3 ;
    var $mced = false ;

    function cleanDB($prefix){
      global $wpdb ;
      $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '$prefix%'") ;
    }

    function plugin_action($links, $file) {
      if ($file == plugin_basename(dirname(__FILE__).'/adsense-now-lite.php')){
      $settings_link = "<a href='options-general.php?page=adsense-now-lite.php'>" .
        __('Settings', 'easy-adsenser') . "</a>";
      array_unshift( $links, $settings_link );
      }
      return $links;
    }

    function contentMeta() {
      $adNwOptions = $this->getAdminOptions();
      global $post;
      $meta = get_post_custom($post->ID);
      $adkeys = array('adsense', 'adsense-top', 'adsense-middle', 'adsense-bottom') ;
      $ezkeys = array('adsense', 'show_leadin', 'show_midtext', 'show_leadout') ;
      $metaOptions = array() ;
      // initialize to adNwOptions
      foreach ($ezkeys as $key => $optKey) {
        $metaOptions[$ezkeys[$key]] = $adNwOptions[$optKey] ;
      }
      // overwrite with custom fields
      if (!empty($meta)) {
        foreach ($meta as $key => $val) {
          $tkey = array_search(strtolower(trim($key)), $adkeys) ;
          if ($tkey !== FALSE) {
            $value = strtolower(trim($val[0])) ;
            // ensure valid values for options
            if ($value == 'left' || $value == 'right' || $value == 'center' || $value == 'no') {
              if ($value == 'left' || $value == 'right') $value = 'float:' . $value ;
              if ($value == 'center') $value = 'text-align:' . $value ;
              $metaOptions[$ezkeys[$tkey]] = $value ;
            }
          }
        }
      }
      return $metaOptions ;
    }

    function adsNow_content($content) {
      $adNwOptions = $this->getAdminOptions();
      if ($adNwOptions['kill_pages'] && is_page()) return $content ;
      if ($adNwOptions['kill_home'] && is_home()) return $content ;
      if ($adNwOptions['kill_attach'] && is_attachment()) return $content ;
      if ($adNwOptions['kill_front'] && is_front_page()) return $content ;
      if ($adNwOptions['kill_cat'] && is_category()) return $content ;
      if ($adNwOptions['kill_tag'] && is_tag()) return $content ;
      if ($adNwOptions['kill_archive'] && is_archive()) return $content ;
      $mc = $adNwOptions['mc'] ;
      $this->mced = false ;
      global $nwCount ;
      if ($nwCount >= $this->nwMax) return $content ;
      if(strpos($content, "<!--noadsense-->") !== false) return $content;
      $metaOptions = $this->contentMeta() ;
      if ($metaOptions['adsense'] == 'no') return $content;

      $show_leadin = $metaOptions['show_leadin'] ;
      $leadin = '' ;
      if ($show_leadin != 'no')
      {
        if ($nwCount < $this->nwMax)
        {
          $nwCount++;
          $adText = $this->handleDefaultText($adNwOptions['ad_text']) ;
          $leadin =
            stripslashes($adNwOptions['info'] . "<!-- Post[count: " . $nwCount . "] -->\n" .
                         '<div class="adsense adsense-leadin" style="' .
                         $show_leadin . ';margin: 12px;">' .
                         $this->mc($mc, $adText) . '</div>') ;
        }
      }

      $show_midtext = $metaOptions['show_midtext'] ;
      if ($show_midtext != 'no')
      {
        if ($nwCount < $this->nwMax)
        {
          $poses = array();
          $lastpos = -1;
          $repchar = "<p";
          if(strpos($content, "<p") === false)
            $repchar = "<br";

          while(strpos($content, $repchar, $lastpos+1) !== false){
            $lastpos = strpos($content, $repchar, $lastpos+1);
            $poses[] = $lastpos;
          }
          $half = sizeof($poses);
          while(sizeof($poses) > $half)
            array_pop($poses);
          $pickme = $poses[floor(sizeof($poses)/2)];
          $nwCount++;
          $adText = $this->handleDefaultText($adNwOptions['ad_text']) ;
          $midtext =
            stripslashes($adNwOptions['info'] . "<!-- Post[count: " . $nwCount . "] -->\n" .
                         '<div class="adsense adsense-midtext" style="' .
                         $show_midtext . ';margin: 12px;">' .
                         $this->mc($mc, $adText) . '</div>') ;
          $content = substr_replace($content, $midtext.$repchar, $pickme, 2);
        }
      }

      $show_leadout = $metaOptions['show_leadout'] ;
      $leadout = '' ;
      if ($show_leadout != 'no')
      {
        if ($nwCount < $this->nwMax)
        {
          $nwCount++;
          $adText = $this->handleDefaultText($adNwOptions['ad_text']) ;
          $leadout =
            stripslashes($adNwOptions['info'] . "<!-- Post[count: " . $nwCount . "] -->\n" .
                         '<div class="adsense adsense-leadout" style="' .
                         $show_leadout . ';margin: 12px;">' .
                         $this->mc($mc, $adText) . '</div>') ;
        }
      }

      return $leadin . $content . $leadout ;
    }
  }
} //End Class adsNow

$nwCount = 0 ;

// provide a replacement for htmlspecialchars_decode() (for PHP4 compatibility)
if (!function_exists("htmlspecialchars_decode")) {
  function htmlspecialchars_decode($string,$style=ENT_COMPAT) {
    $translation = array_flip(get_html_translation_table(HTML_SPECIALCHARS,$style));
    if($style === ENT_QUOTES){ $translation['&#039;'] = '\''; }
    return strtr($string,$translation);
  }
}

if (class_exists("adsNow")) {
  $nw_ad = new adsNow();
  if (isset($nw_ad) && !empty($nw_ad->defaults)) {
    //Initialize the admin panel
    if (!function_exists("adsNow_ap")) {
      function adsNow_ap() {
        global $nw_ad ;
        if (function_exists('add_options_page')) {
          $mName = 'AdSense Now! Lite' ;
          add_options_page($mName, $mName, 9, basename(__FILE__),
            array(&$nw_ad, 'printAdminPage'));
        }
      }
    }

    add_filter('the_content', array($nw_ad, 'adsNow_content'));
    add_action('admin_menu', 'adsNow_ap');
    add_action('activate_' . basename(dirname(__FILE__)) . '/' . basename(__FILE__),
               array(&$nw_ad, 'init'));
    add_filter('plugin_action_links', array($nw_ad, 'plugin_action'), -10, 2);
  }
}

?>
