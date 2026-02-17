<?php
/**
 * @package    RSTickets! Pro
 *
 * @copyright  (c) 2010 - 2016 RSJoomla!
 * @link       https://www.rsjoomla.com
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl-3.0.en.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Router\Route;

use Joomla\CMS\HTML\HTMLHelper;

use Joomla\CMS\Language\Text;

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');

// Load JavaScript message titles
Text::script('ERROR');
Text::script('WARNING');
Text::script('NOTICE');
Text::script('MESSAGE');
?>
<form action="<?php echo Route::_('index.php?option=com_rsticketspro&view=note&tmpl=component&layout=edit&id='.(int) $this->item->id.'&ticket_id='.$this->ticket_id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="rst_button_spacer">
		<button type="button" class="btn btn-success" onclick="Joomla.submitbutton('note.apply');"><i class="icon-apply icon-white"></i> <?php echo Text::_('JAPPLY'); ?></button>
		<button type="button" class="btn btn-danger" onclick="Joomla.submitbutton('note.cancel');"><i class="icon-cancel"></i> <?php echo Text::_('JCANCEL'); ?></button>
	</div>
	<?php
	foreach ($this->form->getFieldsets() as $fieldset)
	{
		echo $this->form->renderFieldset($fieldset->name);
	}
	?>

	<?php echo HTMLHelper::_('form.token'); ?>
	<input type="hidden" name="task" value="" />
</form>