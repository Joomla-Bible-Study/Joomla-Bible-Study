/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Joomla.submitbutton = function (task) {
	if (task == '') {
		return false;
	}
	else if (task == 'upload') {
		if (document.adminForm.upload_folder.value == '') {
			alert("<?php echo JText::_('JBS_MED_PATH_OR_FOLDER');?>");
		}
		else if (document.adminForm.upload_server.value == '') {
			alert("<?php echo JText::_('JBS_CMN_SERVER');?>");
		}
		else {
			Joomla.submitform(task);
			return true;
		}
	}
};
