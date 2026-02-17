<?php
/**
* @version 2.0.0
* @package RSTickets! Pro 2.0.0
* @copyright (C) 2010 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Router\Route;

use Joomla\CMS\HTML\HTMLHelper;

use Joomla\CMS\Language\Text;

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');
?>
<form action="<?php echo Route::_('index.php?option=com_rsticketspro&view=cron&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-horizontal" autocomplete="off">
	<?php
	foreach ($this->form->getFieldsets() as $name => $fieldset)
	{
		// add the tab title
		$this->tabs->addTitle($fieldset->label, $fieldset->name);

		$content = '';

		// set description if required
		if (isset($fieldset->description) && !empty($fieldset->description))
		{
			$content .= '<p>' . Text::_($fieldset->description) . '</p>';
		}

		$content .= $this->form->renderFieldset($fieldset->name);

		if ($fieldset->name === 'general')
		{
			$content .= '<div><p><a href="https://www.rsjoomla.com/support/documentation/rsticketspro/frequently-asked-questions/how-do-i-set-up-a-cron-task.html" target="_blank">' . Text::_('RST_ACCOUNT_TYPE_CRON_HOWTO') . '</a></p></div>';
		}

		// add the tab content
		$this->tabs->addContent($content);
	}

	// render tabs
	$this->tabs->render();

	if ($this->item->id)
	{
		echo HTMLHelper::_('bootstrap.renderModal', 'rsticketsproCronModal', array(
			'title' => Text::_('RST_ACCOUNT_TEST_CONNECTION'),
			'url' 	=> Route::_('index.php?option=com_rsticketspro&task=cron.preview&tmpl=component&id=' . $this->item->id, false),
			'height' => 400,
			'backdrop' => 'static'));
	}
	?>
	<div>
		<?php echo HTMLHelper::_('form.token'); ?>
		<input type="hidden" name="task" value="" />
	</div>
</form>