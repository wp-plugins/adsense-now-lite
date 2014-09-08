<?php

/*
  Plugin Name: AdSense Now!
  Plugin URI: http://www.thulasidas.com/adsense
  Description: <em>Lite Version</em>: Get started with AdSense now, and make money from your blog. Configure it at <a href="options-general.php?page=adsense-now-lite.php">Settings &rarr; AdSense Now!</a>.
  Version: 4.41
  Author: Manoj Thulasidas
  Author URI: http://www.thulasidas.com
 */

/*
  Copyright (C) 2008 www.ads-ez.com

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or (at
  your option) any later version.

  This program is distributed in the hope that it will be useful, but
  WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
  General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if (class_exists("AdsNowPro")) {
  $plg = "AdSense Now! Lite";
  $lite = plugin_basename(__FILE__);
  include_once('ezDenyLite.php');
  ezDenyLite($plg, $lite);
}

if (!class_exists("AdsNow")) {

  require_once('EzOptions.php');

  class AdsNow extends EzBasePlugin {

    var $defaults, $positions, $adminMsg;
    var $metaOptions;
    var $kills = array('page', 'sticky', 'home', 'front_page', 'category',
        'tag', 'archive', 'search', 'single', 'attachment');

    function AdsNow() { //constructor
      parent::__construct("adsense-now", "AdSense Now!", __FILE__);
      $this->prefix = 'adsNow';
      $this->adminMsg = '';
      $this->defaults = array('defaultText' => 'Please generate and paste your ad code here. If left empty, the ad location will be highlighted on your blog pages with a reminder to enter your code.');
      $defaultOptions = $this->mkDefaultOptions();
      $this->optionName = $this->prefix . get_option('stylesheet');
      $this->options = get_option($this->optionName);
      if (empty($this->options)) {
        $this->options = $defaultOptions;
      }
      else {
        $this->options = array_merge($defaultOptions, $this->options);
      }
      $this->positions = array(__('Top', 'adsense-now') => 'show_leadin',
          __('Middle', 'adsense-now') => 'show_midtext',
          __('Bottom', 'adsense-now') => 'show_leadout');
    }

    //Returns an array of admin options
    function mkDefaultOptions() {
      $defaultOptions = array('ad_text' => $this->defaults['defaultText'],
          'show_leadin' => 'float:right',
          'show_midtext' => 'float:left',
          'show_leadout' => 'float:right') +
              parent::mkDefaultOptions();
      foreach ($this->kills as $k) {
        $defaultOptions["kill_$k"] = false;
      }
      return $defaultOptions;
    }

    function mkHelpTags() {
      $this->helpTags = array();
      $o = new EzHelpTag('help0');
      $o->title = __('Click for help', 'adsense-now');
      $o->tipTitle = __('How to Set it up', 'adsense-now');
      $o->desc = sprintf(__('A few easy steps to setup %s', 'adsense-now'), "<em>AdSense Now!</em>");
      $this->helpTags[] = $o;

      $o = new EzHelpTag('help1');
      $o->title = __('Click for help', 'adsense-now');
      $o->tipTitle = __('How to Control AdSense on Each Post', 'adsense-now');
      $o->desc = __('Need to control ad blocks on each post?', 'adsense-now');
      $this->helpTags[] = $o;

      $o = new EzHelpPopUp('http://wordpress.org/extend/plugins/adsense-now-lite/');
      $o->title = __('Click for help', 'adsense-now');
      $o->desc = __('Check out the FAQ and rate this plugin.', 'adsense-now');
      $this->helpTags[] = $o;
    }

    function mkEzOptions() {
      if (!empty($this->ezOptions)) {
        return;
      }

      parent::mkEzOptions();

      $o = new EzTextArea('ad_text');
      $o->before = "<b>" . __('Ad Blocks in Your Posts', 'adsense-now') .
              "</b>&nbsp;";
      $o->desc = __('[Appears in your posts and pages]', 'adsense-now')
              . '<br /><br />';
      $o->style = "width:96%;height:200px;";
      $o->width = "50";
      $o->height = "25";
      $o->after = "<br />";
      $this->ezOptions['ad_text'] = clone $o;
      foreach ($this->positions as $position => $slot) {
        $o = new EzRadioBox($slot);
        $o->title = sprintf(__('How to align or suppress the %s ad block', 'adsense-now'), $position);
        $c = $o->addChoice('float:left', 'float:left', '');
        $c->before = '<td>';
        $c->after = "</td>\n";
        $c = $o->addChoice('text-align:center', 'text-align:center', '');
        $c->before = '<td>';
        $c->after = '</td>';
        $c = $o->addChoice('float:right', 'float:right', '');
        $c->before = '<td>';
        $c->after = '</td>';
        $c = $o->addChoice('suppress', 'no', '');
        $c->before = '<td>';
        $c->after = '</td>';
        $this->ezOptions[$slot] = clone $o;
      }

      $o = new EzCheckBox('kill_page');
      $o->title = __('Do not show ads on pages. Ad will appear on posts. Please see the differece at http://support.wordpress.com/post-vs-page/', 'adsense-now');
      $o->desc = __('Pages (Ads only on Posts)', 'adsense-now');
      $o->before = "&nbsp;";
      $o->after = "<br />";
      $this->ezOptions['kill_page'] = clone $o;

      $o = new EzCheckBox('kill_sticky');
      $o->title = __('Suppress ads on sticky front page. Sticky front page is a post used as the front page of the blog.', 'adsense-now');
      $o->desc = __('Sticky Front Page', 'adsense-now');
      $o->labelWidth = "35%";
      $this->ezOptions['kill_sticky'] = clone $o;

      $o = new EzCheckBox('kill_home');
      $o->title = __('Home Page and Front Page are the same for most blogs', 'adsense-now');
      $o->desc = __('Home Page', 'adsense-now');
      $o->labelWidth = "25%";
      $this->ezOptions['kill_home'] = clone $o;

      $o = new EzCheckBox('kill_front_page');
      $o->title = __('Home Page and Front Page are the same for most blogs', 'adsense-now');
      $o->desc = __('Front Page', 'adsense-now');
      $o->labelWidth = "30%";
      $o->after = "<br />";
      $this->ezOptions['kill_front_page'] = clone $o;

      $o = new EzCheckBox('kill_category');
      $o->title = __('Pages that come up when you click on category names', 'adsense-now');
      $o->desc = __('Category Pages', 'adsense-now');
      $o->labelWidth = "35%";
      $this->ezOptions['kill_category'] = clone $o;

      $o = new EzCheckBox('kill_tag');
      $o->title = __('Pages that come up when you click on tag names', 'adsense-now');
      $o->desc = __('Tag Pages', 'adsense-now');
      $o->labelWidth = "25%";
      $this->ezOptions['kill_tag'] = clone $o;

      $o = new EzCheckBox('kill_archive');
      $o->title = __('Pages that come up when you click on year/month archives', 'adsense-now');
      $o->desc = __('Archive Pages', 'adsense-now');
      $o->labelWidth = "30%";
      $o->after = "<br />";
      $this->ezOptions['kill_archive'] = clone $o;

      $o = new EzCheckBox('kill_search');
      $o->title = __('Pages showing search results', 'adsense-now');
      $o->desc = __('Search Results', 'adsense-now');
      $o->labelWidth = "35%";
      $this->ezOptions['kill_search'] = clone $o;

      $o = new EzCheckBox('kill_single');
      $o->title = __('Posts (ads will be shown only on other kind of pages as specified in these checkboxes)', 'adsense-now');
      $o->desc = __('Single Posts', 'adsense-now');
      $o->labelWidth = "25%";
      $this->ezOptions['kill_single'] = clone $o;

      $o = new EzCheckBox('kill_attachment');
      $o->title = __('Pages that show attachments', 'adsense-now');
      $o->desc = __('Attachment Page', 'adsense-now');
      $o->labelWidth = "30%";
      $o->after = "<br />";
      $this->ezOptions['kill_attachment'] = clone $o;
    }

    function handleDefaultText($text, $key = '300x250') {
      $ret = $text;
      if ($ret == $this->defaults['defaultText'] || strlen(trim($ret)) == 0) {
        $x = strpos($key, 'x');
        $w = substr($key, 0, $x);
        $h = substr($key, $x + 1);
        $p = (int) (min($w, $h) / 6);
        $ret = '<div style="width:' . $w . 'px;height:' . $h . 'px;border:1px solid red;"><div style="padding:' . $p . 'px;text-align:center;font-family:arial;font-size:8pt;"><p>Your ads will be inserted here by</p><p><b>AdSense Now!</b>.</p><p>Please go to the plugin admin page to paste your ad code.</p></div></div>';
      }
      return $ret;
    }

    function isKilled() {
      $killed = false;
      foreach ($this->kills as $k) {
        $fn = "is_$k";
        if ($this->options["kill_$k"] && $fn()) {
          $killed = true;
        }
      }
      return $killed;
    }

    function migrateOptions() {
      $update = false;
      $lookup = array('info' => '',
          'limit_lu' => '',
          'allow_exitjunction' => '',
          'kill_pages' => 'kill_page',
          'kill_attach' => 'kill_attachment',
          'kill_front' => 'kill_front_page',
          'kill_cat' => 'kill_category',
          'mc' => '',
          'gFilter' => '',
          'filterValue' => '',
          'bannedIPs' => '',
          'compatMode' => '');
      foreach ($lookup as $k => $v) {
        if (isset($this->options[$k])) {
          if (!empty($v)) {
            $this->options[$v] = $this->options[$k];
          }
          unset($this->options[$k]);
          $update = true;
        }
      }
      if ($update) {
        update_option($this->optionName, $this->options);
      }
    }

    //Prints out the admin page
    function printAdminPage() {
      $ez = parent::printAdminPage();
      if (empty($ez)) {
        return;
      }
      if (empty($this->defaults)) {
        return;
      }
      $this->handleSubmits();
      if (file_exists($this->plgDir . '/admin.php')) {
        echo $this->adminMsg;
        include ($this->plgDir . '/admin.php');
      }
      else {
        echo '<font size="+1" color="red">' .
        __("Error locating the admin page!\nEnsure admin.php exists, or reinstall the plugin.", 'adsense-now') .
        '</font>';
      }
    }

    var $nwMax = 3;

    function plugin_action($links, $file) {
      if ($file == plugin_basename($this->plgDir . '/adsense-now-lite.php')) {
        $settings_link = "<a href='options-general.php?page=adsense-now-lite.php'>" .
                __('Settings', 'adsense-now') . "</a>";
        array_unshift($links, $settings_link);
      }
      return $links;
    }

    function getMetaOptions() {
      global $post;
      $lookup = array('adsense' => 'adsense',
          'adsense-top' => 'show_leadin',
          'adsense-middle' => 'show_midtext',
          'adsense-bottom' => 'show_leadout');
      $metaOptions = array();
      foreach ($lookup as $metaKey => $optKey) {
        if (!empty($this->options[$optKey])) {
          $metaOptions[$optKey] = $this->options[$optKey];
        }
        else {
          $metaOptions[$optKey] = '';
        }
        $customStyle = get_post_custom_values($metaKey, $post->ID, true);
        if (is_array($customStyle)) {
          $metaStyle = strtolower($customStyle[0]);
        }
        else {
          $metaStyle = strtolower($customStyle);
        }
        $style = '';
        if ($metaStyle == 'left') {
          $style = 'float:left;display:block;';
        }
        else if ($metaStyle == 'right') {
          $style = 'float:right;display:block;';
        }
        else if ($metaStyle == 'center') {
          $style = 'text-align:center;display:block;';
        }
        else {
          $style = $metaStyle;
        }
        if (!empty($style)) {
          $metaOptions[$optKey] = $style;
        }
      }
      $this->metaOptions = $metaOptions;
      return $metaOptions;
    }

    function mkAdBlock($adText, $slot) {
      $show = $this->metaOptions["show_$slot"];
      $info = $this->info();

      $adBlock = stripslashes("$info\n<!-- Post[$slot] -->\n" .
              '<div class="adsense adsense-' . $slot . '" style="' .
              $show . ';margin: 12px;">' .
              $adText . "</div>\n$info\n");
      return $adBlock;
    }

    function filterContent($content) {
      if (!in_the_loop()) {
        return $content;
      }
      if ($this->isKilled()) {
        return $content;
      }
      if (strpos($content, "<!--noadsense-->") !== false) {
        return $content;
      }
      $metaOptions = $this->getMetaOptions();
      if ($metaOptions['adsense'] == 'no') {
        return $content;
      }

      $adText = $this->handleDefaultText($this->options['ad_text']);

      $show_leadin = $metaOptions['show_leadin'];
      $leadin = '';
      if ($show_leadin != 'no') {
        $leadin = $this->mkAdBlock($adText, 'leadin');
      }

      $show_midtext = $metaOptions['show_midtext'];
      if ($show_midtext != 'no') {
        $poses = array();
        $lastpos = -1;
        $repchar = "<p";
        if (strpos($content, "<p") === false) {
          $repchar = "<br";
        }

        while (strpos($content, $repchar, $lastpos + 1) !== false) {
          $lastpos = strpos($content, $repchar, $lastpos + 1);
          $poses[] = $lastpos;
        }
        $half = sizeof($poses);
        while (sizeof($poses) > $half) {
          array_pop($poses);
        }
        $pickme = $poses[floor(sizeof($poses) / 2)];
        $midtext = $this->mkAdBlock($adText, 'midtext');
        $content = substr_replace($content, $midtext . $repchar, $pickme, 2);
      }

      $show_leadout = $metaOptions['show_leadout'];
      $leadout = '';
      if ($show_leadout != 'no') {
        $leadout = $this->mkAdBlock($adText, 'leadout');
      }

      return $leadin . $content . $leadout;
    }

  }

} //End Class adsNow

if (class_exists("AdsNow")) {
  $adsNow = new AdsNow();
  if (isset($adsNow) && !empty($adsNow->defaults)) {
    //Initialize the admin panel
    if (!function_exists("adsNow_ap")) {

      function adsNow_ap() {
        global $adsNow;
        if (function_exists('add_options_page')) {
          $mName = 'AdSense Now!';
          add_options_page($mName, $mName, 'activate_plugins', basename(__FILE__), array($adsNow, 'printAdminPage'));
        }
      }

    }

    add_filter('the_content', array($adsNow, 'filterContent'));
    add_action('admin_menu', 'adsNow_ap');
    add_filter('plugin_action_links', array($adsNow, 'plugin_action'), -10, 2);
    register_activation_hook(__FILE__, array($adsNow, 'migrateOptions'));
  }
}
