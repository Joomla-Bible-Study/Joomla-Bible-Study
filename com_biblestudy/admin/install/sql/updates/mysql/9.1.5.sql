CREATE TABLE IF NOT EXISTS `#__bsms_update` (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  version VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id)
) DEFAULT CHARSET=utf8;

INSERT INTO `#__bsms_update` (version) VALUES ('9.1.5')
ON DUPLICATE KEY UPDATE version = '9.1.5';
INSERT INTO `#__bsms_templatecode` ( `published`, `type`, `filename`, `templatecode`) VALUES
( 1, 1, ''easy'', ''<?php\r\n\r\n/**\r\n * Helper for Template Code\r\n *\r\n * @package    Proclaim.Admin\r\n * @copyright  2007 - 2018 (C) CWM Team All rights reserved\r\n * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL\r\n * @link       https://www.christianwebministries.org\r\n * */\r\n// No Direct Access\r\ndefined(\''_JEXEC\'') or die;\r\n\r\n// Do not remove\r\n// this is here to make sure that security of the site is maintained. It should be placed in every template file\r\nJHtml::addIncludePath(JPATH_COMPONENT . \''/helpers/html\'');\r\n\r\nJHtml::_(\''bootstrap.tooltip\'');\r\nJHtml::_(\''dropdown.init\'');\r\nJHtml::_(\''behavior.multiselect\'');\r\nJHtml::_(\''formbehavior.chosen\'', \''select\'');\r\n\r\n$app       = JFactory::getApplication();\r\n$user      = JFactory::getUser();\r\n$userId    = $user->get(\''id\'');\r\n$listOrder = $this->escape($this->state->get(\''list.ordering\''));\r\n$listDirn  = $this->escape($this->state->get(\''list.direction\''));\r\n$archived  = $this->state->get(\''filter.published\'') == 2 ? true : false;\r\n$trashed   = $this->state->get(\''filter.published\'') == -2 ? true : false;\r\n$saveOrder = $listOrder == \''study.ordering\'';\r\n$columns   = 12;\r\n\r\n\r\n\r\n?>\r\n<style>img{border-radius:4px;}</style>\r\n\r\n\r\n  <div class=\"row-fluid span12\">\r\n    <h2>\r\n      Teachings\r\n    </h2>\r\n  </div>\r\n\r\n\r\n\r\n  <div class=\"row-fluid span12 dropdowns\" style=\"background-color:#A9A9A9; margin:0 -5px; padding:8px 8px; border:1px solid #C5C1BE; position:relative; -webkit-border-radius:10px;\">\r\n\r\n    <?php\r\n    echo $this->page->books;\r\n    echo $this->page->teachers;\r\n    echo $this->page->series;\r\n    $oddeven = \''\'';\r\n	$class1 = \''#d3d3d3\'';\r\n    $class2 = \''\'';?>\r\n</div>\r\n<?php foreach ($this->items as $study)\r\n{\r\n\r\n	$oddeven = ($oddeven == $class1) ? $class2 : $class1;\r\n	?>\r\n	<div style=\"width:100%;\">\r\n		<div class=\"span3\"><div style=\"padding:12px 8px;line-height:22px;height:200px;\">\r\n				<?php if ($study->study_thumbnail) {echo \''<span style=\"max-width:250px; height:auto;\">\''.$study->study_thumbnail .\''</span>\''; echo \''<br />\'';} ?>\r\n				<strong><?php echo $study->studytitle;?></strong><br />\r\n				<span style=\"color:#9b9b9b;\"><?php echo $study->scripture1;?> | <?php echo $study->studydate;?></span><br />\r\n				<div style=\"font-size:85%;margin-bottom:-17px;max-height:122px;overflow:hidden;\"><?php echo $study->teachername;?></div><br /><div style=\"background: rgba(0, 0, 0, 0) linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, white 100%) repeat scroll 0 0;bottom: 0;height: 32px;margin-top: -32px; position: relative;width: 100%;\"></div>\r\n				<?php echo $study->media; ?>\r\n			</div></div>\r\n\r\n\r\n	</div>\r\n<?php }?>\r\n<div class=\"row-fluid span12 pagination pagelinks\" style=\"background-color: #A9A9A9;\r\n	margin: 0 -5px;\r\n	padding: 8px 8px;\r\n	border: 1px solid #C5C1BE;\r\n	position: relative;\r\n	-webkit-border-radius: 9px;\">\r\n	<?php echo $this->pagination->getPageslinks();?>\r\n</div>\r\n'');
