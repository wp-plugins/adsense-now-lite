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

echo '<script type="text/javascript" src="' . $this->plgURL . '/wz_tooltip.js"></script>';
$this->mkEzOptions();
$this->setOptionValues();
$this->mkHelpTags();
?>
<div class="wrap" style="width:1000px">

  <h2>Now! Plugin for AdSense</h2>
  <table class="form-table">
    <tr style="vertical-align:middle">
      <td style="width:40%">
        <?php
        echo "<h3>";
        _e('Instructions', 'adsense-now');
        echo "</h3>\n<ul style='padding-left:10px;list-style-type:circle; list-style-position:inside;'>\n";
        foreach ($this->helpTags as $help) {
          echo "<li>";
          $help->render();
          echo "</li>\n";
        }
        ?>
        </ul>
      </td>
      <?php
      include ($this->plgDir . '/head-text.php');
      ?>
    </tr></table>
  <form method='post' action='#'>
    <?php
    $this->renderNonce();
    $ez->renderNags($this->options);
    ?>
    <br />

    <table>
      <tr><td><h3><?php printf(__('Options (for the %s theme)', 'adsense-now'), get_option('stylesheet')); ?></h3></td></tr>
    </table>

    <table style="width:100%">
      <tr>
        <td style="width:450px">
          <?php $this->ezOptions['ad_text']->render(); ?>
        </td>
        <td style="width:400px">
          <?php
          echo "<b>";
          _e('Ad Alignment', 'adsense-now');
          echo "</b>&nbsp;";
          _e('(Where to show?)', 'adsense-now');
          ?>

          <table style="width:450px;vertical-align:middle;text-align:center;padding:2px">
            <tr>
              <td>&nbsp;</td>
              <td><?php _e('Align Left', 'adsense-now'); ?> </td>
              <td><?php _e('Center', 'adsense-now'); ?> </td>
              <td><?php _e('Align Right', 'adsense-now'); ?> </td>
              <td><?php _e('Suppress', 'adsense-now'); ?></td>
            </tr>
            <?php
            foreach ($this->positions as $position => $slot) {
              echo "<tr><td>$position</td>";
              $this->ezOptions[$slot]->render();
              echo "</tr>\n";
            }
            ?>
            <tr style='vertical-align:top;text-align:left'>
              <td colspan="5" style='width:50%;vertical-align:middle'>
                <br />
                <?php
                echo "<b>";
                _e('Suppress AdSense Ad Blocks on:', 'adsense-now');
                echo "</b>";
                foreach ($this->kills as $k) {
                  $this->ezOptions["kill_$k"]->render();
                }
                ?>
                <br style='line-height: 5px;' />
                <div style="background-color:#cff;padding:5px;border: solid 1px;margin-top:10px;">
                  <?php
                  echo '<span onmouseover="TagToTip(\'pro\', WIDTH, 350, TITLE, \'Buy the Pro Version\',STICKY, 1, CLOSEBTN, true, CLICKCLOSE, true, FIX, [this, 5, 5])"><b>Buy the <a href="http://buy.ads-ez.com/adsense-now" target="_blank">Pro Version</a></b>&nbsp; More features, more power!<br /></span>';
                  ?>
                </div>
              </td></tr>
          </table>

        </td>
      </tr>
    </table>

    <div class="submit">
      <?php
      $update = new EzSubmit('saveChanges');
      $update->desc = __('Save Changes', 'adsense-now');
      $update->title = __('Save the changes as specified above', 'adsense-now');
      $update->tipTitle = $update->desc;

      $reset = new EzSubmit('resetOptions');
      $reset->desc = __('Reset Options', 'adsense-now');
      $reset->title = __('This <b>Reset Options</b> button discards all your changes and loads the default options. This is your only warning!', 'adsense-now');
      $reset->tipWarning = true;

      $cleanDB = new EzSubmit('cleanDB');
      $cleanDB->desc = __('Clean Database', 'adsense-now');
      $cleanDB->title = __('The <b>Database Cleanup</b> button discards all your AdSense settings you have saved so far for <b>all</b> the themes, including the current one. Use it only if you know that you will not be using these themes. Please be careful with all database operations -- keep a backup.', 'adsense-now');
      $cleanDB->tipWarning = true;

      $uninstall = new EzSubmit('uninstall');
      $uninstall->desc = __('Uninstall', 'adsense-now');
      $uninstall->title = __('The <b>Uninstall</b> button really kills %s after cleaning up all the options it wrote in your database. This is your only warning! Please be careful with all database operations -- keep a backup.', 'adsense-now');
      $uninstall->tipWarning = true;

      $update->render();
      $reset->render();
      $cleanDB->render();
      $uninstall->render();
      $this->ezTran->renderTranslator();
      ?>
    </div>
  </form>

  <span id="help0" style='display:none'>
    <?php
    echo "1. ";
    _e('Generate AdSense code (from http://adsense.google.com &rarr; AdSense Setup &rarr; Get Ads).', 'adsense-now');
    echo "<br />\n2. ";
    _e('Cut and paste the AdSense code into the boxes below, deleting the existing text.', 'adsense-now');
    echo "<br />\n3. ";
    _e('Decide how to align and show the code in your blog posts.', 'adsense-now');
    echo "<br />\n4. ";
    _e('Take a look at the Google policy option, and other options. The defaults should work.', 'adsense-now');
    echo "<br />\n5. ";
    printf(__('If you want to use the widgets, drag and drop them at %s Appearance (or Design) &rarr; Widgets %s', 'adsense-now'), '<a href="widgets.php">', '</a>.');
    echo "<br />\n<b>";
    _e('Save the options, and you are done!', 'adsense-now');
    echo "</b>";
    ?>
  </span>

  <span id="help1" style='display:none'>
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
no', 'adsense-now'); ?>
  </span>

  <?php
  $ez->renderWhyPro();
  $ez->renderSupport();
  include ($this->plgDir . '/tail-text.php');
  ?>

  <table class="form-table" >
    <tr><th scope="row"><b><?php _e('Credits', 'adsense-now'); ?></b></th></tr>
    <tr><td>
        <ul style="padding-left:10px;list-style-type:circle; list-style-position:inside;" >
          <li>
            <?php printf(__('%s uses the excellent Javascript/DHTML tooltips by %s', 'adsense-now'), '<b>Adsense Now! Lite</b>', '<a href="http://www.walterzorn.com" target="_blank" title="Javascript, DTML Tooltips"> Walter Zorn</a>.');
            ?>
          </li>
        </ul>
      </td>
    </tr>
  </table>
</div>

