<?php
/**
 * Batch Template
 *
 * @package    Proclaim.Admin
 * @copyright  2007 - 2019 (C) CWM Team All rights reserved
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       https://www.christianwebministries.org
 * */
defined('_JEXEC') or die;

$published = $this->state->get('filter.published');
JHtml::addIncludePath(BIBLESTUDY_PATH_ADMIN_HELPERS . '/html');
?>

<div class="row-fluid">
	<div class="control-group span4">
		<div class="controls">
			<?php echo JHtml::_('batch.access'); ?>
		</div>
	</div>
	<div class="control-group span4">
		<div class="controls">
			<?php echo JHtml::_('biblestudy.Teacher'); ?>
		</div>
	</div>
	<div class="control-group span4">
		<div class="controls">
			<?php echo JHtml::_('biblestudy.Messagetype'); ?>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="control-group span4">
		<div class="controls">
			<?php echo JHtml::_('biblestudy.Series'); ?>
		</div>
	</div>
	<div class="control-group span4">
		<div class="controls">
			<?php echo JHtml::_('batch.language'); ?>
		</div>
	</div>
</div>
