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

// Load JavaScript message titles
Text::script('ERROR');
Text::script('WARNING');
Text::script('NOTICE');
Text::script('MESSAGE');
Text::script('RST_PLEASE_SELECT');
Text::script('RST_DEPARTMENT');
Text::script('RST_TICKET_SUBJECT');
Text::script('RST_TICKET_MESSAGE');
Text::script('RST_PRIORITY');
Text::script('RST_TICKET_STATUS');
Text::script('RST_CUSTOM_FIELD');
Text::script('RST_IS_EQUAL');
Text::script('RST_IS_NOT_EQUAL');
Text::script('RST_IS_LIKE');
Text::script('RST_IS_NOT_LIKE');
Text::script('RST_AND');
Text::script('RST_OR');
Text::script('RST_IF');

HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('jquery.framework');
HTMLHelper::_('script', 'com_rsticketspro/kbrules.js', array('relative' => true, 'version' => 'auto'));
?>
<form action="<?php echo Route::_('index.php?option=com_rsticketspro&view=kbrule&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-horizontal">
	<?php
	foreach ($this->form->getFieldsets() as $fieldset)
	{
		echo $this->form->renderFieldset($fieldset->name);
	}
	?>
	
	<div>
		<?php echo HTMLHelper::_('form.token'); ?>
		<input type="hidden" name="task" value="" />
	</div>
</form>