<?php

class AdSenseNowFront {

  var $leadin, $leadout, $options, $defaultText;
  static $ezMax = 3, $ezCount = 0;

  function AdSenseNowFront() {
    $optionSet = EzGA::getMobileType();
    if ($optionSet == "Killed") {
      EzGA::$noAds = true;
      $optionSet = "";
    }
    $this->options = EzGA::getOptions($optionSet);
    $this->defaultText = $this->options['defaultText'];
  }

  function mkAdBlock($slot) {
    self::$ezCount++;
    $adText = EzGA::handleDefaultText($this->options['ad_text']);
    $info = EzGA::info();
    if (empty($adText)) {
      $adBlock = "\n$info\n<!-- Empty adText: Post[$slot] Count:" .
              self::$ezCount . " of " . self::$ezMax . "-->\n";
    }
    else {
      $show = EzGA::$metaOptions["show_$slot"];
      $adBlock = stripslashes("\n$info\n<!-- Post[$slot] Count:" .
              self::$ezCount . " of " . self::$ezMax . "-->\n" .
              "<div class='adsense adsense-$slot' style='$show;margin:12px'>" .
              "$adText</div>\n$info\n");
    }
    return $adBlock;
  }

  function filterContent($content) {
    $content = EzGA::preFilter($content);
    if (EzGA::$noAds) {
      return $content;
    }

    $plgName = EzGA::getPlgName();
    if (self::$ezCount >= self::$ezMax) {
      return $content . " <!-- $plgName: Unfiltered [count: " .
              self::$ezCount . " is not less than " . self::$ezMax . "] -->";
    }

    $adMax = self::$ezMax;
    $adCount = 0;
    if (!is_singular()) {
      if (isset(EzGA::$options['excerptNumber'])) {
        $adMax = EzGA::$options['excerptNumber'];
      }
    }

    list($content, $return) = EzGA::filterShortCode($content);
    if ($return) {
      return $content;
    }

    $metaOptions = EzGA::getMetaOptions();
    $show_leadin = $metaOptions['show_leadin'];
    $leadin = '';
    if ($show_leadin != 'no') {
      if (self::$ezCount < self::$ezMax && $adCount++ < $adMax) {
        $leadin = $this->mkAdBlock("leadin");
      }
    }

    $show_midtext = $metaOptions['show_midtext'];
    $midtext = '';
    if ($show_midtext != 'no') {
      if (self::$ezCount < self::$ezMax && $adCount++ < $adMax) {
        $midtext = $this->mkAdBlock("midtext");
        if (!EzGA::$foundShortCode) {
          $paras = EzGA::findParas($content);
          $half = sizeof($paras);
          while (sizeof($paras) > $half) {
            array_pop($paras);
          }
          $split = 0;
          if (!empty($paras)) {
            $split = $paras[floor(sizeof($paras) / 2)];
          }
          $content = substr($content, 0, $split) . $midtext . substr($content, $split);
        }
      }
    }

    $show_leadout = $metaOptions['show_leadout'];
    $leadout = '';
    if ($show_leadout != 'no') {
      if (self::$ezCount < self::$ezMax && $adCount++ < $adMax) {
        $leadout = $this->mkAdBlock("leadout");
        if (!EzGA::$foundShortCode && strpos($show_leadout, "float") !== false) {
          $paras = EzGA::findParas($content);
          $split = array_pop($paras);
          if (!empty($split)) {
            $content1 = substr($content, 0, $split);
            $content2 = substr($content, $split);
          }
        }
      }
    }
    if (EzGA::$foundShortCode) {
      $content = EzGA::handleShortCode($content, $leadin, $midtext, $leadout);
    }
    else {
      if (empty($content1)) {
        $content = $leadin . $content . $leadout;
      }
      else {
        $content = $leadin . $content1 . $leadout . $content2;
      }
    }
    return $content;
  }

}

$adSenseNow = new AdSenseNowFront();
if (!empty($adSenseNow)) {
  add_filter('the_content', array($adSenseNow, 'filterContent'));
  if (EzGA::isPro()) {
    if (!empty(EzGA::$options['enableShortCode'])) {
      $shortCodes = array('ezadsense', 'adsense');
      foreach ($shortCodes as $sc) {
        add_shortcode($sc, array('EzGAPro', 'processShortcode'));
      }
    }
  }
}
