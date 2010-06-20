<?php defined('_JEXEC') or die('Restricted access');
require_once (JPATH_ROOT  .DS. 'components' .DS. 'com_biblestudy' .DS. 'lib' .DS. 'biblestudy.debug.php');
require_once (JPATH_ROOT  .DS. 'components' .DS. 'com_biblestudy' .DS. 'lib' .DS. 'biblestudy.defines.php');
require_once (BIBLESTUDY_PATH_LIB .DS. 'biblestudy.version.php');
//dump ($this->admin, 'admin: ');

?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Administration' ); //dump ($this->admin, 'admin: ');?></legend>

		
    <table class="admintable">
    <tr><td class="key"><?php echo JText::_('Administrative Settings');?></td><td>
    <?php

	jimport('joomla.html.pane');
	$pane =& JPane::getInstance( 'sliders' );
 
echo $pane->startPane( 'content-pane' );
 
echo $pane->startPanel( JText::_( 'General' ), 'GENERAL' );
echo $this->params->render( 'params' );
echo $pane->endPanel();

echo $pane->startPanel( JText::_( 'Images Folders' ), 'FILLIN-IMAGES' );
echo $this->params->render( 'params' , 'FILLIN-IMAGES');
echo $pane->endPanel();

echo $pane->startPanel( JText::_( 'Auto Fill Study Record' ), 'FILLIN-STUDY' );
echo $this->params->render( 'params' , 'FILLIN-STUDY');
echo $pane->endPanel(); 

echo $pane->startPanel( JText::_( 'Auto Fill Media File Record' ), 'FILLIN-MEDIAFILE' );
echo $this->params->render( 'params' , 'FILLIN-MEDIAFILE');
echo $pane->endPanel(); 

echo $pane->startPanel( JText::_( 'Front End Submission' ), 'SUBMISSION' );
echo $this->params->render( 'params' , 'SUBMISSION');
echo $pane->endPanel(); 

echo $pane->startPanel( JText::_( 'All Videos Reloaded Compatability' ), 'ALLVIDEOSRELOADED' );
echo $this->params->render( 'params' , 'ALLVIDEOSRELOADED');
echo $pane->endPanel(); 

echo $pane->endPane();?>
<tr><td class="key"><?php echo JText::_('Default Study List Image');?></td><td><?php 
if ($this->lists['main'])
{
    echo $this->lists['main']; echo JText::_(' Default for Study List Page Image. Media images folder used (set above).');
}
else
{
    echo JText::_('There was a problem finding the list. Ensure that at minimum there is an images/stories folder');
}
?></td></tr>
<tr><td class="key"><?php echo JText::_('Default Study Image');?></td><td><?php 
if ($this->lists['study'])
{
    echo $this->lists['study']; echo JText::_(' Default for study thumbnail. Set Folder above.');
}
else
{
    echo JText::_('There was a problem finding the list. Ensure that at minimum there is an images/stories folder');
}
?></td></tr>
<tr><td class="key"><?php echo JText::_('Default Series Image');?></td><td><?php 
if ($this->lists['series'])
{
    echo $this->lists['series']; echo JText::_(' Default for series thumbnail. Set Folder above.');
}
else
{
    echo JText::_('There was a problem finding the list. Ensure that at minimum there is an images/stories folder');
}
?></td></tr>

<tr><td class="key"><?php echo JText::_('Default Teacher Image');?></td><td><?php 
if ($this->lists['teacher'])
{
    echo $this->lists['teacher']; echo JText::_(' Default for teacher thumbnail. Set Folder above.');
}
else
{
    echo JText::_('There was a problem finding the list. Ensure that at minimum there is an images/stories folder');
}
?></td></tr>
<tr><td class="key"><?php echo JText::_('Download Image');?></td><td><?php 
if ($this->lists['download'])
{
    echo $this->lists['download']; echo JText::_(' Default for download image. Must be called download.png. Media images folder used (set above).');
}
else
{
    echo JText::_('There was a problem finding the list. Ensure that at minimum there is an images/stories folder');
}
?></td></tr>
<tr><td class="key"><?php echo JText::_('Default Show/Hide Image for Landing Page');?></td><td><?php echo $this->lists['showhide']; echo JText::_(' Default for Show/Hide Image on Landing Page. Media images folder used (set above).');?></td></tr>

<?php //test for sh404SEF
jimport('joomla.filesystem.file');
$dest = JPATH_SITE.DS.'/components/com_sh404sef/index.html';
$sh404exists = JFile::exists($dest);
if ($sh404exists)
{
	?>
	<tr><td class="key"><?php echo JText::_('sh404SEF maintenance'); ?></td><td><a href="index.php?option=com_biblestudy&view=admin&controller=admin&task=updatesef">Update sh404SEF links for com_biblestudy</a></td></tr>
	<?php
}
?>
      <tr> <td class="key"><?php echo JText::_('Version');?></td>
      	<td> 
		<?php $version = CBiblestudyVersion::versionArray(); 
		echo 'Version: <strong>'.$version->version.'</strong> Date: '.$version->versiondate.' Build: '.$version->build.' Version Name: '.$version->versionname; ?>
       <br />
		<?php echo JText::_('Current Version:').' '.$this->versioncheck; ?></strong><br />
        <a href="http://www.JoomlaBibleStudy.org" target="_blank"><?php echo JText::_('Get Latest Version');?></a></td>
      </tr>

    </table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_biblestudy" />
<input type="hidden" name="id" value="1" />
<input type="hidden" name="controller" value="admin" />
<input type="hidden" name="task" value="save" />
</form>
