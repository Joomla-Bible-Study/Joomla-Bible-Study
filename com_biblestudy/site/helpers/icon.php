<?php
/**
 * @package    BibleStudy.Site
 * @copyright  (C) 2007 - 2013 Joomla Bible Study Team All rights reserved
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link       http://www.JoomlaBibleStudy.org
 * Notice: Undefined property: stdClass::$created_by_alias in /Users/bcordis/PhpstormProjects/Joomla-Bible-Study/com_biblestudy/site/helpers/icon.php on line 154
Call Stack
 * */
// No direct access
defined('_JEXEC') or die;

/**
 * Content Component HTML Helper
 *
 * @static
 * @package     BibleStudy.Site
 * @since       7.0.0
 *
 * @deprecated  7.0.0
 */
class JHtmlIcon
{

	public static function print_popup($article, $params, $attribs = array())
	{
		$url = JBSMHelperRoute::getArticleRoute($article->slug);
		$url .= '&tmpl=component&print=1&layout=default&page=' . @ $request->limitstart;

		$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';

		// checks template image directory for image, if non found default are loaded
		if ($params->get('show_icons'))
		{
			$text = '<i class="icon-print"></i> ' . JText::_('JGLOBAL_PRINT');
		}
		else
		{
			$text = JText::_('JGLOBAL_PRINT');
		}

		$attribs['title']   = JText::_('JGLOBAL_PRINT');
		$attribs['onclick'] = "window.open(this.href,'win2','" . $status . "'); return false;";
		$attribs['rel']     = 'nofollow';

		return JHtml::_('link', JRoute::_($url), $text, $attribs);
	}

	public static function create($category, $params)
	{
		$uri = JURI::getInstance();

		$url = 'index.php?option=com_content&task=article.add&return=' . base64_encode($uri) . '&a_id=0&catid=' . $category->id;

		if ($params->get('show_icons'))
		{
			$text = '<i class="icon-plus"></i> ' . JText::_('JNEW') . '&#160;';
		}
		else
		{
			$text = JText::_('JNEW') . '&#160;';
		}

		$button = JHtml::_('link', JRoute::_($url), $text, 'class="btn btn-primary"');

		$output = '<span class="hasTip" title="' . JText::_('COM_CONTENT_CREATE_ARTICLE') . '">' . $button . '</span>';

		return $output;
	}

	public static function email($article, $params, $attribs = array())
	{
		require_once JPATH_SITE . '/components/com_mailto/helpers/mailto.php';
		$uri      = JURI::getInstance();
		$base     = $uri->toString(array('scheme', 'host', 'port'));
		$template = JFactory::getApplication()->getTemplate();
		$link     = $base . JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid), false);
		$url      = 'index.php?option=com_mailto&tmpl=component&template=' . $template . '&link=' . MailToHelper::addLink($link);

		$status = 'width=400,height=350,menubar=yes,resizable=yes';

		if ($params->get('show_icons'))
		{
			$text = '<i class="icon-envelope"></i> ' . JText::_('JGLOBAL_EMAIL');
		}
		else
		{
			$text = JText::_('JGLOBAL_EMAIL');
		}

		$attribs['title']   = JText::_('JGLOBAL_EMAIL');
		$attribs['onclick'] = "window.open(this.href,'win2','" . $status . "'); return false;";

		$output = JHtml::_('link', JRoute::_($url), $text, $attribs);

		return $output;
	}

	/**
	 * Display an edit icon for the article.
	 *
	 * This icon will not display in a popup window, nor if the article is trashed.
	 * Edit access checks must be performed in the calling code.
	 *
	 * @param    object    $article       The article in question.
	 * @param    object    $params        The article parameters
	 * @param    array     $attribs       Not used??
	 *
	 * @return    string    The HTML for the article edit icon.
	 * @since    1.6
	 */
	public static function edit($article, $params, $attribs = array())
	{
		$user   = JFactory::getUser();
		$userId = $user->get('id');
		$uri    = JURI::getInstance();

		// Ignore if in a popup window.
		if ($params && $params->get('popup'))
		{
			return;
		}

		// Ignore if the state is negative (trashed).
		if ($article->published < 0)
		{
			return;
		}

		JHtml::_('behavior.tooltip');

		$url = 'index.php?option=com_biblestudy&view=sermon&task=sermon.edit&a_id=' . $article->id . '&return=' . base64_encode($uri);

		if ($article->published == 0)
		{
			$overlib = JText::_('JUNPUBLISHED');
		}
		else
		{
			$overlib = JText::_('JPUBLISHED');
		}

		$icon = $article->published ? 'edit' : 'eye-close';
		$text = '<i class="hasTip icon-' . $icon . ' tip" title="' . JText::_('JBS_COM_EDIT_ITEM') . ' :: ' . $overlib . '"></i> ' . JText::_('JGLOBAL_EDIT');

		$output = JHtml::_('link', JRoute::_($url), $text);

		return $output;
	}

	public static function print_screen($article, $params, $attribs = array())
	{
		// checks template image directory for image, if non found default are loaded
		if ($params->get('show_icons'))
		{
			$text = $text = '<i class="icon-print"></i> ' . JText::_('JGLOBAL_PRINT');
		}
		else
		{
			$text = JText::_('JGLOBAL_PRINT');
		}

		return '<a href="#" onclick="window.print();return false;">' . $text . '</a>';
	}

}
