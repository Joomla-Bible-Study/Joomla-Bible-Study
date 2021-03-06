<?php
/**
 * Default
 *
 * @package    Proclaim.Admin
 * @copyright  2007 - 2019 (C) CWM Team All rights reserved
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       https://www.christianwebministries.org
 * */
// No Direct Access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.framework');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$app        = JFactory::getApplication();
$user       = JFactory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->escape($this->state->get('list.ordering'));
$listDirn   = $this->escape($this->state->get('list.direction'));
$archived   = $this->state->get('filter.published') == 2 ? true : false;
$trashed    = $this->state->get('filter.published') == -2 ? true : false;
$saveOrder  = $listOrder == 'ordering';
$sortFields = $this->getSortFields();
$columns    = 9;

JFactory::getDocument()->addScriptDeclaration('
	Joomla.orderTable = function()
	{
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != "' . $listOrder . '")
		{
			dirn = "asc";
		}
		else
		{
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, "");
	};
');
?>
<form action="<?php echo JRoute::_('index.php?option=com_biblestudy&view=comments'); ?>" method="post" name="adminForm"
      id="adminForm">
	<?php if (!empty($this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
		<hr/>
	</div>
	<div id="j-main-container" class="span10">
		<?php else : ?>
		<div id="j-main-container">
			<?php endif; ?>
			<?php
			// Search tools bar
			echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
			?>
			<?php if (empty($this->items)) : ?>
				<div class="alert alert-no-items">
					<?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
				</div>
			<?php else : ?>
				<table class="table table-striped adminlist" id="comments">
					<thead>
					<tr>
						<th width="1%" class="hidden-phone">
							<?php echo JHtml::_('grid.checkall'); ?>
						</th>
						<th width="1%" style="min-width:55px;" class="nowrap center">
							<?php echo JHtml::_('grid.sort', 'JBS_CMN_PUBLISHED', 'comment.published', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('grid.sort', 'JBS_CMN_TITLE', 'study.studytitle', $listDirn, $listOrder); ?>
						</th>
						<th width="10%" class="nowrap hidden-phone">
							<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ACCESS', 'comment.access', $listDirn, $listOrder); ?>
						</th>
						<th class="nowrap hidden-phone">
							<?php echo JHtml::_('grid.sort', 'JBS_CMT_FULL_NAME', 'comment.full_name', $listDirn, $listOrder); ?>
						</th>
						<th class="nowrap hidden-phone">
							<?php echo JText::_('JBS_CMT_TEXT'); ?>
						</th>
						<th class="nowrap hidden-phone">
							<?php echo JHtml::_('grid.sort', 'JBS_CMT_CREATE_DATE', 'comment.studydate', $listDirn, $listOrder); ?>
						</th>
						<th width="5%" class="nowrap hidden-phone">
							<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_LANGUAGE', 'language', $listDirn, $listOrder); ?>
						</th>
						<th width="1%" class="nowrap hidden-phone">
							<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'comment.id', $listDirn, $listOrder); ?>
						</th>
					</tr>
					</thead>
					<tfoot>
					<tr>
						<td colspan="<?php echo $columns; ?>">
						</td>
					</tr>
					</tfoot>
					<tbody>
					<?php
					foreach ($this->items as $i => $item) :
						$link = JRoute::_('index.php?option=com_biblestudy&task=comment.edit&id=' . (int) $item->id);
						$canCreate = $user->authorise('core.create');
						$canEdit = $user->authorise('core.edit', 'com_biblestudy.comment.' . $item->id);
						$canEditOwn = $user->authorise('core.edit.own', 'com_biblestudy.comment.' . $item->id);
						$canChange = $user->authorise('core.edit.state', 'com_biblestudy.comment.' . $item->id);
						?>
						<tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo '1' ?>">

							<td class="center hidden-phone">
								<?php echo JHtml::_('grid.id', $i, $item->id); ?>
							</td>
							<td class="center">
								<div class="btn-group">
									<?php echo JHtml::_('jgrid.published', $item->published, $i, 'comments.', $canChange, 'cb', '', ''); ?><?php

									// Create dropdown items
									$action = $archived ? 'unarchive' : 'archive';
									JHtml::_('actionsdropdown.' . $action, 'cb' . $i, 'comments');

									$action = $trashed ? 'untrash' : 'trash';
									JHtml::_('actionsdropdown.' . $action, 'cb' . $i, 'comments');

									// Render dropdown list
									echo JHtml::_('actionsdropdown.render', $this->escape($item->studytitle));
									?>
								</div>
							</td>

							<td class="nowrap has-context" style="width:10%;">
								<div class="pull-left">
									<?php if ($canEdit || $canEditOwn) : ?>
										<a href="<?php echo $link; ?>"><?php echo $this->escape($item->studytitle) . ' - '
												. JText::_($item->bookname) . ' ' . $item->chapter_begin; ?></a>
									<?php else : ?>
										<?php echo $this->escape($item->studytitle) . ' - ' . JText::_($item->bookname) . ' ' . $item->chapter_begin; ?>
									<?php endif; ?>
								</div>
							</td>
							<td class="small hidden-phone">
								<?php echo $this->escape($item->access_level); ?>
							</td>
							<td class="nowrap has-context">
								<?php echo $item->full_name; ?>
							</td>
							<td>
								<?php echo substr($item->comment_text, 0, 50); ?>
							</td>
							<td class="nowrap has-context">
								<?php echo $item->comment_date; ?>
							</td>
							<td class="small hidden-phone">
								<?php if ($item->language == '*'): ?>
									<?php echo JText::alt('JALL', 'language'); ?>
								<?php else: ?>
									<?php echo $item->language_title ? $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
								<?php endif; ?>
							</td>
							<td class="center hidden-phone">
								<?php echo (int) $item->id; ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
			<?php echo $this->pagination->getListFooter(); ?>
			<?php // Load the batch processing form. ?>
			<?php echo $this->loadTemplate('batch'); ?>
			<input type="hidden" name="task" value=""/>
			<input type="hidden" name="boxchecked" value="0"/>
			<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
			<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
			<?php echo JHtml::_('form.token'); ?>
		</div>
</form>
