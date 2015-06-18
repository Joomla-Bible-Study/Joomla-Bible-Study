<?php
/**
 * Default Main
 *
 * @package    BibleStudy.Site
 * @copyright  2007 - 2013 Joomla Bible Study Team All rights reserved
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://www.JoomlaBibleStudy.org
 * */
// No Direct Access
defined('_JEXEC') or die;

JHtml::_('bootstrap.framework');

$mainframe = JFactory::getApplication();
$input = new JInput;
$option = $input->get('option', '', 'cmd');
$JViewLegacy = new JViewLegacy;
$JBSMSerieslist = new JBSMSerieslist;
JHTML::_('behavior.tooltip');
$series_menu = $this->params->get('series_id', 1);

$params = $this->params;
$url = $params->get('stylesheet');
switch ($this->params->get('series_element'))
{
    case 0:
        $classelement = '';
        break;
    case 1:
        $classelement = 'p';
        break;
    case 2:
        $classelement = 'h1';
        break;
    case 3:
        $classelement = 'h2';
        break;
    case 4:
        $classelement = 'h3';
        break;
    case 5:
        $classelement = 'h4';
        break;
    case 6:
        $classelement = 'h5';
        break;
    case 7:
        $classelement = 'blockquote';
}
if ($url)
{
	$document->addStyleSheet($url);
}
?>
<div class="container-fluid">

	<form action="<?php echo str_replace("&", "&amp;", $this->request_url); ?>" method="post" name="adminForm">
		<div class="hero-unit"> <!-- This div is the header container -->

			<<?php echo $classelement; ?> class="componentheading">
				<?php
				if ($this->params->get('show_page_image_series'))
				{
					echo '<img src="' . JURI::base() . $this->params->get('show_page_image_series') . '" alt="' . $this->params->get('show_series_title') . '" />';

					// End of column for logo
				}
				?>
				<?php
				if ($this->params->get('show_series_title') > 0)
				{
					echo $this->params->get('series_title');
				}
				?>
			</<?php echo $classelement; ?>>
		</div>
		<!--header-->

		<div id="bsdropdownmenu">

			<?php

			if ($this->params->get('series_list_show_pagination') == 1)
			{
				echo '<span class="display-limit">' . JText::_('JGLOBAL_DISPLAY_NUM') . $this->pagination->getLimitBox() . '</span>';
			}
			if ($this->params->get('search_series') == 1)
			{
				echo $this->page->series;
			}
			if ($this->params->get('series_list_teachers') == 1)
			{
				echo $this->page->teachers;
			}
			if ($this->params->get('series_list_years') == 1)
			{
				echo $this->page->years;
			}
			if ($this->go > 0)
			{
				echo $this->page->gobutton;
			}
			?>
		</div>

		<?php $listing = new JBSMListing;
		$list = $listing->getFluidListing($this->items, $this->params, $this->template, $type = 'seriesdisplays');
		echo $list;
		?>

		<div class="listingfooter pagination">
			<?php
			if ($this->params->get('series_list_show_pagination') == 2)
			{
				echo '<span class="display-limit">' . JText::_('JGLOBAL_DISPLAY_NUM') . $this->pagination->getLimitBox() . '</span>';
			}
			echo $this->pagination->getPageslinks();
			?>
		</div>
		<!--end of bsfooter div-->

		<!--end of bspagecontainer div-->
		<input name="option" value="com_biblestudy" type="hidden">
		<input name="task" value="" type="hidden">
		<input name="boxchecked" value="0" type="hidden">
		<input name="controller" value="seriesdisplays" type="hidden">
</form>
</div> <!-- end of container-fluid div -->
