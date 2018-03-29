<?php
/**
 * Default
 *
 * @package    BibleStudy.Site
 * @copyright  2007 - 2018 (C) CWM Team All rights reserved
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       https://www.christianwebministries.org
 * */
// No Direct Access
defined('_JEXEC') or die;
$style = 'body { background-color:' . $this->params->get('popupbackground', 'black') . ' !important; padding:0 !important;}
	#all{background-color:' . $this->params->get('popupbackground', 'black') . ' !important;}';
$doc = JFactory::getDocument();
$doc->addStyleDeclaration($style);
$jbsmedia = new JBSMMedia();
?>
<div id="popupwindow" class="popupwindow">
	<div class="popuptitle"><p class="popuptitle"><?php echo $this->headertext ?>
		</p>
	</div>
	<?php
	// Here is where we choose whether to use the Internal Viewer or All Videos
	if ($this->params->get('player') == 3 || $this->player == 3 || $this->params->get('player') == 2 || $this->player == 2)
	{
		$mediacode = $this->getMedia->getAVmediacode($this->media->mediacode, $this->media);
		echo JHtml::_('content.prepare', $mediacode);
	}
	// Legacy Player (since JBS 6.2.2) is now deprecated and will be rendered with JWPlayer.
	if ($this->params->get('player') == 1 || $this->player == 1 || $this->player == 7)
	{
		$player = new stdClass;
		$player->mp3 = ($this->player == '7' ? true : false);
		JHtml::_('jwplayer.framework');
		if (preg_match('(youtube.com|youtu.be)', $path) === 1)
+		{
+			echo JHtml::_('<iframe width="' . $player->playerwidth . '" height="' . $player->playerheight . '" src="' .
+			$jbsmedia->convertYoutube($path) . '" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>');
+		}
+		elseif (preg_match('(vimeo.com)', $path) === 1)
+		{
+			echo JHtml::_('<iframe src="' . $jbsmedia->convertVimeo($path) . '" width="' . $player->playerwidth . '" height="' . $player->playerheight .
+			'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');
+		}
+		else
+		{
+			echo JHtml::_('jwplayer.render', $this->media, $this->params, true, $player);
+		}
	}

	if ($this->player == 8)
	{
		echo stripslashes($this->params->get('mediacode'));
	}

	if ($this->player == 0)
	{
		echo '<a href="' . JRoute::_($this->path1) . '"> Link to: ' .
			$this->media->studytitle . '</a>';
	}
	?>
	<div class="popupfooter">
		<p class="popupfooter">
			<?php echo $this->footertext; ?>
		</p>
	</div>
</div>

