<?php
/*
Copyright (C) 2008 www.thulasidas.com

This file is part of the program "AdSense Now!"

AdSense Now! is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or (at
your option) any later version.

AdSense Now! is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

@include(dirname (__FILE__).'/myPlugins.php');

echo '<script type="text/javascript" src="'. get_option('siteurl') . '/' . PLUGINDIR . '/' .  basename(dirname(__FILE__)) . '/wz_tooltip.js"></script>' ?>
<div class="wrap" style="width:850px">

<h2>AdSense Now! Setup</h2>

<form method="post" name="adsenser" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
<?php
  $plgDir = dirname(__FILE__) ;
  $plgName = 'adsense-now' ;
  if (!$adNwOptions['kill_rating']) renderRating($myPlugins[$plgName], $plgDir) ;
  if (!$adNwOptions['kill_invites']) renderInvite($myPlugins[$plgName], $plgName) ;
?>

<table class="form-table">
<tr><th scope="row" colspan=3><b><?php _e('Instructions', 'easy-adsenser') ; ?></b></th></tr>
<tr>
<td style="width:37%;">
<ul style="padding-left:10px;list-style-type:circle; list-style-position:inside;" >
<li>
<a href="#" title="<?php _e('Click for help', 'easy-adsenser') ; ?>" onclick="TagToTip('help0',WIDTH, 270, TITLE, '<?php _e('How to Set it up', 'easy-adsenser') ; ?>', STICKY, 1, CLOSEBTN, true, CLICKCLOSE, true, FIX, [this, 15, 5])">
<?php
printf(__('A few easy steps to setup %s', 'easy-adsenser'),'<em>AdSense Now! Lite</em>') ;
?></a><br />
</li>
<li>
<a href="#" title="<?php _e('Click for help', 'easy-adsenser') ; ?>" onclick="TagToTip('help1',WIDTH, 270, TITLE, '<?php _e('How to Control AdSense on Each Post', 'easy-adsenser') ; ?>', STICKY, 1, CLOSEBTN, true, CLICKCLOSE, true, FIX, [this, 15, 5])">
<?php _e('Need to control ad blocks on each post?', 'easy-adsenser') ;?></a><br />
</li>
</ul>
</td>

<?php @include (dirname (__FILE__).'/head-text.php'); ?>

</tr>
</table>

<br />

<table class="form-table">
<tr><th scope="row"><b><?php printf(__('Options (for the %s theme)', 'easy-adsenser'), $mThemeName); ?></b></th></tr>
</table>

<table class="form-table" style="width:100%">
<tr>
<td style="width:450px">
<b><?php _e('Ad Blocks in Your Posts', 'easy-adsenser') ; ?></b><br />
<?php _e('[Appears in your posts and pages]', 'easy-adsenser') ; ?><br />
<textarea cols="50" rows="25" name="adsNowText" style="width: 96%; height: 250px;"><?php echo(stripslashes(htmlspecialchars($adNwOptions['ad_text']))) ?></textarea>

<br style="line-height: 25px;" />

</td>
<td style="width:400px">
<b><?php _e('Ad Alignment', 'easy-adsenser') ; ?></b>&nbsp;
<b><?php _e('(Where to show?)', 'easy-adsenser') ; ?></b>
<table style="background-color=#fff;width:450px;vertical-align:middle;text-align:center;">
<tr>
<td>&nbsp;</td><td><?php _e('Align Left', 'easy-adsenser') ; ?> </td><td><?php _e('Center', 'easy-adsenser') ; ?> </td><td><?php _e('Align Right', 'easy-adsenser') ; ?> </td><td><?php _e('Suppress', 'easy-adsenser') ; ?></td></tr>
<tr>
<td><?php _e('Top', 'easy-adsenser') ; ?></td>
<td>
<input type="radio" id="adsNowShowLeadin_left" name="adsNowShowLeadin" value="float:left" <?php if ($adNwOptions['show_leadin'] == "float:left") { echo('checked="checked"'); }?> />
</td><td>
<input type="radio" id="adsNowShowLeadin_center" name="adsNowShowLeadin" value="text-align:center" <?php if ($adNwOptions['show_leadin'] == "text-align:center") { echo('checked="checked"'); }?> />
</td><td>
<input type="radio" id="adsNowShowLeadin_right" name="adsNowShowLeadin" value="float:right" <?php if ($adNwOptions['show_leadin'] == "float:right") { echo('checked="checked"'); }?> />
</td><td>
<input type="radio" id="adsNowShowLeadin_no" name="adsNowShowLeadin" value="no" <?php if ($adNwOptions['show_leadin'] == "no") { echo('checked="checked"'); }?> />
</td></tr>
<tr>
<td><?php _e('Middle', 'easy-adsenser') ; ?></td>
<td>
<input type="radio" id="adsNowShowMidtext_left" name="adsNowShowMidtext" value="float:left" <?php if ($adNwOptions['show_midtext'] == "float:left") { echo('checked="checked"'); }?> />
</td><td>
<input type="radio" id="adsNowShowMidtext_center" name="adsNowShowMidtext" value="text-align:center" <?php if ($adNwOptions['show_midtext'] == "text-align:center") { echo('checked="checked"'); }?> />
</td><td>
<input type="radio" id="adsNowShowMidtext_right" name="adsNowShowMidtext" value="float:right" <?php if ($adNwOptions['show_midtext'] == "float:right") { echo('checked="checked"'); }?> />
</td><td>
<input type="radio" id="adsNowShowMidtext_no" name="adsNowShowMidtext" value="no" <?php if ($adNwOptions['show_midtext'] == "no") { echo('checked="checked"'); }?> />
</td></tr>
<tr>
<td><?php _e('Bottom', 'easy-adsenser') ; ?></td>
<td>
<input type="radio" id="adsNowShowLeadout_left" name="adsNowShowLeadout" value="float:left" <?php if ($adNwOptions['show_leadout'] == "float:left") { echo('checked="checked"'); }?> />
</td><td>
<input type="radio" id="adsNowShowLeadout_center" name="adsNowShowLeadout" value="text-align:center" <?php if ($adNwOptions['show_leadout'] == "text-align:center") { echo('checked="checked"'); }?> />
</td><td>
<input type="radio" id="adsNowShowLeadout_right" name="adsNowShowLeadout" value="float:right" <?php if ($adNwOptions['show_leadout'] == "float:right") { echo('checked="checked"'); }?> />
</td><td>
<input type="radio" id="adsNowShowLeadout_no" name="adsNowShowLeadout" value="no" <?php if ($adNwOptions['show_leadout'] == "no") { echo('checked="checked"'); }?> />
</td>
</tr>
<tr><td colspan="5" style="text-align:left;">
<b><?php _e('Suppress AdSense Ad Blocks on:', 'easy-adsenser') ; ?></b>&nbsp;&nbsp;
<input type="checkbox" id="adNwKillPages" name="adNwKillPages" value="true" <?php if ($adNwOptions['kill_pages']) { echo('checked="checked"'); }?> /> <a href="http://codex.wordpress.org/Pages" target="_blank" title="<?php _e('Click to see the difference between posts and pages', 'easy-adsenser') ; ?>"><?php _e('Pages (Ads only on Posts)', 'easy-adsenser') ; ?></a><br />
<label for="adNwKillAttach" title="<?php _e('Pages that show attachments', 'easy-adsenser') ; ?>">
<input type="checkbox" id="adNwKillAttach" name="adNwKillAttach" <?php if ($adNwOptions['kill_attach']) { echo('checked="checked"'); }?> /> <?php _e('Attachment Page', 'easy-adsenser') ; ?></label>&nbsp;&nbsp;
<label for="adNwKillHome" title="<?php _e('Home Page and Front Page are the same for most blogs', 'easy-adsenser') ; ?>">
<input type="checkbox" id="adNwKillHome" name="adNwKillHome" <?php if ($adNwOptions['kill_home']) { echo('checked="checked"'); }?> /> <?php _e('Home Page', 'easy-adsenser') ; ?></label>&nbsp;
<label for="adNwKillFront" title="<?php _e('Home Page and Front Page are the same for most blogs', 'easy-adsenser') ; ?>">
<input type="checkbox" id="adNwKillFront" name="adNwKillFront" <?php if ($adNwOptions['kill_front']) { echo('checked="checked"'); }?> /> <?php _e('Front Page', 'easy-adsenser') ; ?></label>&nbsp;&nbsp;
<br />
<label for="adNwKillCat" title="<?php _e('Pages that come up when you click on category names', 'easy-adsenser') ; ?>">
<input type="checkbox" id="adNwKillCat" name="adNwKillCat" <?php if ($adNwOptions['kill_cat']) { echo('checked="checked"'); }?> /> <?php _e('Category Pages', 'easy-adsenser') ; ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
<label for="adNwKillTag" title="<?php _e('Pages that come up when you click on tag names', 'easy-adsenser') ; ?>">
<input type="checkbox" id="adNwKillTag" name="adNwKillTag" <?php if ($adNwOptions['kill_tag']) { echo('checked="checked"'); }?> /> <?php _e('Tag Pages', 'easy-adsenser') ; ?></label>&nbsp;&nbsp;&nbsp;
<label for="adNwKillArchive" title="<?php _e('Pages that come up when you click on year/month archives', 'easy-adsenser') ; ?>">
<input type="checkbox" id="adNwKillArchive" name="adNwKillArchive" <?php if ($adNwOptions['kill_archive']) { echo('checked="checked"'); }?> /> <?php _e('Archive Pages', 'easy-adsenser') ; ?></label>&nbsp;&nbsp;
<br style="line-height: 30px;" />
<br />
<div style="background-color:#cff;padding:5px;border: solid 1px;margin-top:10px;">
<?php
   echo '<span onmouseover="TagToTip(\'pro\', WIDTH, 350, TITLE, \'Buy the Pro Version\',STICKY, 1, CLOSEBTN, true, CLICKCLOSE, true, FIX, [this, 5, 5])"><b>Buy the <a href="http://buy.ads-ez.com/adsense-now" target="_blank">Pro Version</a></b>&nbsp; More features, more power!<br /></span>' ;
?>
</div>
</td></tr>
</table>

</td>
</tr>
</table>

<div class="submit">
<input type="submit" name="update_adsNowSettings" value="<?php _e('Save Changes', 'easy-adsenser') ?>" title="<?php _e('Save the changes as specified above', 'easy-adsenser') ?>" onmouseover="Tip('<?php _e('Save the changes as specified above', 'easy-adsenser') ?>',WIDTH, 240, TITLE, 'Save Settings')" onmouseout="UnTip()"/>
<input type="submit" name="reset_adsNowSettings"  value="<?php _e('Reset Options', 'easy-adsenser') ?>" onmouseover="TagToTip('help3',WIDTH, 240, TITLE, 'DANGER!', BGCOLOR, '#ffcccc', FONTCOLOR, '#800000',BORDERCOLOR, '#c00000')" onmouseout="UnTip()"/>
<input type="submit" name="clean_db"  value="<?php _e('Clean Database', 'easy-adsenser') ?>" onmouseover="TagToTip('help4',WIDTH, 280, TITLE, 'DANGER!', BGCOLOR, '#ffcccc', FONTCOLOR, '#800000',BORDERCOLOR, '#c00000')" onmouseout="UnTip()"/>
<input type="submit" name="kill_me"  value="<?php _e('Uninstall', 'easy-adsenser') ?>" onmouseover="TagToTip('help5',WIDTH, 280, TITLE, 'DANGER!', BGCOLOR, '#ffcccc', FONTCOLOR, '#800000',BORDERCOLOR, '#c00000')" onmouseout="UnTip()"/>
</div>
</form>

<span id="help0">
1.
<?php
_e('Generate AdSense code (from http://adsense.google.com &rarr; AdSense Setup &rarr; Get Ads).', 'easy-adsenser') ;
?>
<br />
2.
<?php
_e('Cut and paste the AdSense code into the boxes below, deleting the existing text.', 'easy-adsenser') ;
?>
<br />
3.
<?php
_e('Decide how to align and show the code in your blog posts.', 'easy-adsenser') ;
?>
<br />
<b>
<?php
_e('Save the options, and you are done!', 'easy-adsenser') ;
?>
</b>
</span>

<span id="help1">
<?php _e('If you want to suppress AdSense in a particular post or page, give the <b><em>comment </em></b> "&lt;!--noadsense--&gt;" somewhere in its text.
<br />
<br />
Or, insert a <b><em>Custom Field</em></b> with a <b>key</b> "adsense" and give it a <b>value</b> "no".<br />
<br />
Other <b><em>Custom Fields</em></b> you can use to fine-tune how a post or page displays AdSense blocks:<br />
<b>Keys</b>:<br />
adsense-top,
adsense-middle,
adsense-bottom,
adsense-widget,
adsense-search<br />
<b>Values</b>:<br />
left,
right,
center,
no', 'easy-adsenser') ;?>
</span>

<span id="help3">
<span style="font-color:#f00;"><?php _e('This <b>Reset Options</b> button discards all your changes and loads the default options. This is your only warning!', 'easy-adsenser') ; ?></span><br />
<b><?php _e('Discard all your changes and load defaults. (Are you quite sure?)', 'easy-adsenser') ?></b></span>
<span id="help4" style="font-color:#f00;">
<?php _e('The <b>Database Cleanup</b> button discards all your AdSense settings you have saved so far for <b>all</b> the themes, including the current one. Use it only if you know that you won\'t be using these themes. Please be careful with all database operations -- keep a backup.', 'easy-adsenser') ; ?><br />
<b><?php _e('Discard all your changes and load defaults. (Are you quite sure?)', 'easy-adsenser') ?></b></span>
<span id="help5" style="font-color:#f00;">
<?php printf(__('The <b>Uninstall</b> button really kills %s after cleaning up all the options it wrote in your database. This is your only warning! Please be careful with all database operations -- keep a backup.', 'easy-adsenser'), '<em>AdSense Now! Lite</em>') ; ?><br />
<b><?php _e('Kill this plugin. (Are you quite sure?)', 'easy-adsenser') ?></b></span>
<hr />

<?php
if (!$adNwOptions['kill_invites']) {
  echo '<div style="background-color:#cff;padding:5px;border: solid 1px;margin:5px;">' ;
  @include (dirname (__FILE__).'/why-pro.php');
  echo '</div>' ;
}
?>

<div style="background-color:#fcf;padding:5px;border: solid 1px;margin:5px;">
<?php @include (dirname (__FILE__).'/support.php'); ?>
</div>

<?php include (dirname (__FILE__).'/tail-text.php'); ?>

<table class="form-table" >
<tr><th scope="row"><b><?php _e('Credits', 'easy-adsenser'); ?></b></th></tr>
<tr><td>
<ul style="padding-left:10px;list-style-type:circle; list-style-position:inside;" >
<li>
<?php printf(__('%s uses the excellent Javascript/DHTML tooltips by %s', 'easy-adsenser'), '<b>Adsense Now! Lite</b>', '<a href="http://www.walterzorn.com" target="_blank" title="Javascript, DTML Tooltips"> Walter Zorn</a>.') ;
?>
</li>
</ul>
</td>
</tr>
</table>

<?php echo '</div>' ; ?>
