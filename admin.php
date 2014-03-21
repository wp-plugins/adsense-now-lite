<?php

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

echo '<script type="text/javascript" src="'. $this->plgURL . '/wz_tooltip.js"></script>' ?>
<div class="wrap" style="width:1000px">

<h2>AdSense Now! Setup</h2>

<form method="post" name="adsenser" action="">
<?php
  $plgDir = $this->plgDir ;
  $plgName = 'adsense-now' ;
  if (!$adNwOptions['kill_rating']) $ez->renderRating() ;
  if (!$adNwOptions['kill_invites']) $ez->renderInvite() ;
?>

<table class="form-table">
<tr><td colspan=3><h3><?php _e('Instructions', 'adsense-now') ; ?></h3></td></tr>
<tr>
<td style="width:37%;">
<ul style="padding-left:10px;list-style-type:circle; list-style-position:inside;" >
<li>
<a href="#" title="<?php _e('Click for help', 'adsense-now') ; ?>" onclick="TagToTip('help0',WIDTH, 270, TITLE, '<?php _e('How to Set it up', 'adsense-now') ; ?>', STICKY, 1, CLOSEBTN, true, CLICKCLOSE, true, FIX, [this, 15, 5])">
<?php
printf(__('A few easy steps to setup %s', 'adsense-now'),'<em>AdSense Now! Lite</em>') ;
?></a><br />
</li>
<li>
<a href="#" title="<?php _e('Click for help', 'adsense-now') ; ?>" onclick="TagToTip('help1',WIDTH, 270, TITLE, '<?php _e('How to Control AdSense on Each Post', 'adsense-now') ; ?>', STICKY, 1, CLOSEBTN, true, CLICKCLOSE, true, FIX, [this, 15, 5])">
<?php _e('Need to control ad blocks on each post?', 'adsense-now') ;?></a><br />
</li>
</ul>
</td>

<?php @include ($this->plgDir.'/head-text.php'); ?>

</tr>
</table>

<br />

<table>
<tr><td><h3><?php printf(__('Options (for the %s theme)', 'adsense-now'), $mThemeName); ?></h3></td></tr>
</table>

<table style="width:100%">
<tr>
<td style="width:450px">
<h4><?php _e('Ad Blocks in Your Posts', 'adsense-now') ; ?></h4>
<h5><?php _e('[Appears in your posts and pages]', 'adsense-now') ; ?></h5>
<textarea cols="50" rows="25" name="adsNowText" style="width: 96%; height: 200px;"><?php echo(stripslashes(htmlspecialchars($adNwOptions['ad_text']))) ?></textarea>

</td>
<td style="width:400px">
<h4><?php _e('Ad Alignment', 'adsense-now') ; ?></h4>
<h5><?php _e('(Where to show?)', 'adsense-now') ; ?></h5>

<table style="background-color:#fff;width:450px;vertical-align:middle;text-align:center;padding:2px">
<tr>
<td>&nbsp;</td><td><?php _e('Align Left', 'adsense-now') ; ?> </td><td><?php _e('Center', 'adsense-now') ; ?> </td><td><?php _e('Align Right', 'adsense-now') ; ?> </td><td><?php _e('Suppress', 'adsense-now') ; ?></td></tr>
<tr>
<td><?php _e('Top', 'adsense-now') ; ?></td>
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
<td><?php _e('Middle', 'adsense-now') ; ?></td>
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
<td><?php _e('Bottom', 'adsense-now') ; ?></td>
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
<b style="display:inline-block;width:35%"><?php _e('Suppress AdSense Ad Blocks on:', 'adsense-now') ; ?></b>
<input type="checkbox" id="adNwKillPages" name="adNwKillPages" value="true" <?php if ($adNwOptions['kill_pages']) { echo('checked="checked"'); }?> /> <a href="http://codex.wordpress.org/Pages" target="_blank" title="<?php _e('Click to see the difference between posts and pages', 'adsense-now') ; ?>"><?php _e('Pages (Ads only on Posts)', 'adsense-now') ; ?></a><br />
<label style="display:inline-block;width:35%" for="adNwKillAttach" title="<?php _e('Pages that show attachments', 'adsense-now') ; ?>">
<input type="checkbox" id="adNwKillAttach" name="adNwKillAttach" <?php if ($adNwOptions['kill_attach']) { echo('checked="checked"'); }?> /> <?php _e('Attachment Page', 'adsense-now') ; ?></label>
<label style="display:inline-block;width:25%" for="adNwKillHome" title="<?php _e('Home Page and Front Page are the same for most blogs', 'adsense-now') ; ?>">
<input type="checkbox" id="adNwKillHome" name="adNwKillHome" <?php if ($adNwOptions['kill_home']) { echo('checked="checked"'); }?> /> <?php _e('Home Page', 'adsense-now') ; ?></label>
<label style="display:inline-block;width:30%" for="adNwKillFront" title="<?php _e('Home Page and Front Page are the same for most blogs', 'adsense-now') ; ?>">
<input type="checkbox" id="adNwKillFront" name="adNwKillFront" <?php if ($adNwOptions['kill_front']) { echo('checked="checked"'); }?> /> <?php _e('Front Page', 'adsense-now') ; ?></label>
<br />
<label style="display:inline-block;width:35%" for="adNwKillCat" title="<?php _e('Pages that come up when you click on category names', 'adsense-now') ; ?>">
<input type="checkbox" id="adNwKillCat" name="adNwKillCat" <?php if ($adNwOptions['kill_cat']) { echo('checked="checked"'); }?> /> <?php _e('Category Pages', 'adsense-now') ; ?></label>
<label style="display:inline-block;width:25%" for="adNwKillTag" title="<?php _e('Pages that come up when you click on tag names', 'adsense-now') ; ?>">
<input type="checkbox" id="adNwKillTag" name="adNwKillTag" <?php if ($adNwOptions['kill_tag']) { echo('checked="checked"'); }?> /> <?php _e('Tag Pages', 'adsense-now') ; ?></label>
<label style="display:inline-block;width:30%" for="adNwKillArchive" title="<?php _e('Pages that come up when you click on year/month archives', 'adsense-now') ; ?>">
<input type="checkbox" id="adNwKillArchive" name="adNwKillArchive" <?php if ($adNwOptions['kill_archive']) { echo('checked="checked"'); }?> /> <?php _e('Archive Pages', 'adsense-now') ; ?></label>
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
<input type="submit" name="update_adsNowSettings" value="<?php _e('Save Changes', 'adsense-now') ?>" title="<?php _e('Save the changes as specified above', 'adsense-now') ?>" onmouseover="Tip('<?php _e('Save the changes as specified above', 'adsense-now') ?>',WIDTH, 240, TITLE, 'Save Settings')" onmouseout="UnTip()"/>
<input type="submit" name="reset_adsNowSettings"  value="<?php _e('Reset Options', 'adsense-now') ?>" onmouseover="TagToTip('help3',WIDTH, 240, TITLE, 'DANGER!', BGCOLOR, '#ffcccc', FONTCOLOR, '#800000',BORDERCOLOR, '#c00000')" onmouseout="UnTip()"/>
<input type="submit" name="clean_db"  value="<?php _e('Clean Database', 'adsense-now') ?>" onmouseover="TagToTip('help4',WIDTH, 280, TITLE, 'DANGER!', BGCOLOR, '#ffcccc', FONTCOLOR, '#800000',BORDERCOLOR, '#c00000')" onmouseout="UnTip()"/>
<input type="submit" name="kill_me"  value="<?php _e('Uninstall', 'adsense-now') ?>" onmouseover="TagToTip('help5',WIDTH, 280, TITLE, 'DANGER!', BGCOLOR, '#ffcccc', FONTCOLOR, '#800000',BORDERCOLOR, '#c00000')" onmouseout="UnTip()"/>
</div>
<?php $this->ezTran->renderTranslator();?>
</form>

<span id="help0">
1.
<?php
_e('Generate AdSense code (from http://adsense.google.com &rarr; AdSense Setup &rarr; Get Ads).', 'adsense-now') ;
?>
<br />
2.
<?php
_e('Cut and paste the AdSense code into the boxes below, deleting the existing text.', 'adsense-now') ;
?>
<br />
3.
<?php
_e('Decide how to align and show the code in your blog posts.', 'adsense-now') ;
?>
<br />
<b>
<?php
_e('Save the options, and you are done!', 'adsense-now') ;
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
no', 'adsense-now') ;?>
</span>

<span id="help3">
<span style="font-color:#f00;"><?php _e('This <b>Reset Options</b> button discards all your changes and loads the default options. This is your only warning!', 'adsense-now') ; ?></span><br />
<b><?php _e('Discard all your changes and load defaults. (Are you quite sure?)', 'adsense-now') ?></b></span>
<span id="help4" style="font-color:#f00;">
<?php _e('The <b>Database Cleanup</b> button discards all your AdSense settings you have saved so far for <b>all</b> the themes, including the current one. Use it only if you know that you won\'t be using these themes. Please be careful with all database operations -- keep a backup.', 'adsense-now') ; ?><br />
<b><?php _e('Discard all your changes and load defaults. (Are you quite sure?)', 'adsense-now') ?></b></span>
<span id="help5" style="font-color:#f00;">
<?php printf(__('The <b>Uninstall</b> button really kills %s after cleaning up all the options it wrote in your database. This is your only warning! Please be careful with all database operations -- keep a backup.', 'adsense-now'), '<em>AdSense Now! Lite</em>') ; ?><br />
<b><?php _e('Kill this plugin. (Are you quite sure?)', 'adsense-now') ?></b></span>
<hr />

<?php
if (!$adNwOptions['kill_invites']) {
  @include ($this->plgDir.'/why-pro.php');
}
?>

<div style="background-color:#fcf;padding:5px;border: solid 1px;margin:5px;">
<?php @include ($this->plgDir.'/support.php'); ?>
</div>

<?php include ($this->plgDir.'/tail-text.php'); ?>

<table class="form-table" >
<tr><th scope="row"><b><?php _e('Credits', 'adsense-now'); ?></b></th></tr>
<tr><td>
<ul style="padding-left:10px;list-style-type:circle; list-style-position:inside;" >
<li>
<?php printf(__('%s uses the excellent Javascript/DHTML tooltips by %s', 'adsense-now'), '<b>Adsense Now! Lite</b>', '<a href="http://www.walterzorn.com" target="_blank" title="Javascript, DTML Tooltips"> Walter Zorn</a>.') ;
?>
</li>
</ul>
</td>
</tr>
</table>
<?php
echo '</div>' ;
