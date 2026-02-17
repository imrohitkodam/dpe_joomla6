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
<form action="<?php echo Route::_('index.php?option=com_rsticketspro&view=tickets'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-horizontal">
	<?php
	foreach ($this->form->getFieldsets() as $fieldset)
	{
		echo $this->form->renderFieldset($fieldset->name);
	}
	?>
	<button type="button" onclick="Joomla.submitbutton('search.perform');" class="button btn btn-primary"><?php echo Text::_('RST_SEARCH'); ?></button>
	</div>
	
	<div>
		<?php echo HTMLHelper::_('form.token'); ?>
		<input type="hidden" name="task" value="" />
	</div>
</form>