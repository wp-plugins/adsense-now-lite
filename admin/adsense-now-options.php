<?php

$ezOptions = array();
$ezOptions['ad_text'] = array('name' => __("Ad Blocks in Your Posts", 'easy-ads') . "<br><small>" . __('[Appears in your posts and pages]', 'easy-adsenser') . "</small>",
    'help' => __("This ad block will appear within the body of your posts and pages. Generate your AdSense code from your Google AdSense page and paste it here.", 'easy-ads'),
    'type' => 'textarea',
    'value' => EzGA::$options['defaultText']);

require 'box-ad-alignment-options.php';
require 'box-suppressing-ads-options.php';
require 'pro-options.php';
