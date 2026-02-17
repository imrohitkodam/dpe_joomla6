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
<form action="<?php echo Route::_('index.php?option=com_rsticketspro&view=predefinedsearch&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	<?php
	foreach ($this->form->getFieldsets() as $fieldset)
	{
		echo $this->form->renderFieldset($fieldset->name);
	}

	if (isset($this->item->params['search']))
	{
		$input = strlen($this->item->params['search']) ? $this->escape($this->item->params['search']) : '<em>' . Text::_('RST_NONE_SUPPLIED') . '</em>';
		$this->showField(Text::_('RST_SEARCH_TEXT'), $input);
	}

	if (isset($this->item->params['customer']))
	{
		$input = strlen($this->item->params['customer']) ? $this->escape($this->item->params['customer']) : '<em>' . Text::_('RST_NONE_SUPPLIED') . '</em>';
		$this->showField(Text::_('RST_SEARCH_CUSTOMER'), $input);
	}

	if (isset($this->item->params['staff']))
	{
		if (strlen($this->item->params['staff']))
		{
			if ((string) $this->item->params['staff'] === '0')
			{
				$input = '<em>' . Text::_('RST_UNASSIGNED') . '</em>';
			}
			else
			{
				$input = $this->escape($this->item->params['staff']);
			}
		}
		else
		{
			$input = '<em>' . Text::_('RST_NONE_SUPPLIED') . '</em>';
		}
		$this->showField(Text::_('RST_SEARCH_STAFF'), $input);
	}

	if (isset($this->item->params['department_id']))
	{
		$departments = $this->getDepartments($this->item->params['department_id']);
		$input = $departments ? $this->escape(implode(', ', $departments)) : '<em>' . Text::_('RST_NONE_SUPPLIED') . '</em>';
		$this->showField(Text::_('RST_SEARCH_DEPARTMENTS'), $input);
	}

	if (isset($this->item->params['priority_id']))
	{
		$priorities = $this->getPriorities($this->item->params['priority_id']);
		$input = $priorities ? $this->escape(implode(', ', $priorities)) : '<em>' . Text::_('RST_NONE_SUPPLIED') . '</em>';
		$this->showField(Text::_('RST_SEARCH_PRIORITIES'), $input);
	}

	if (isset($this->item->params['status_id']))
	{
		$statuses = $this->getStatuses($this->item->params['status_id']);
		$input = $statuses ? $this->escape(implode(', ', $statuses)) : '<em>' . Text::_('RST_NONE_SUPPLIED') . '</em>';
		$this->showField(Text::_('RST_SEARCH_STATUSES'), $input);
	}

	if (isset($this->item->params['flagged']))
	{
		$input = $this->item->params['flagged'] ? Text::_('JYES') : Text::_('JNO');
		$this->showField(Text::_('RST_SEARCH_FLAGGED'), $input);
	}

	if (!empty($this->item->params['from']))
	{
		$input = $this->escape($this->item->params['from']);
		$this->showField(Text::_('COM_RSTICKETSPRO_FROM_DATE'), $input);
	}

	if (!empty($this->item->params['to']))
	{
		$input = $this->escape($this->item->params['to']);
		$this->showField(Text::_('COM_RSTICKETSPRO_TO_DATE'), $input);
	}

	if (!empty($this->item->params['ordering']))
	{
		$input = Text::_('RST_TICKET_'.$this->item->params['ordering']);
		if (!empty($this->item->params['direction']))
		{
			$input .= ' ' . ($this->item->params['direction'] == 'asc' ? Text::_('JGLOBAL_ORDER_ASCENDING') : Text::_('JGLOBAL_ORDER_DESCENDING'));
		}
		$this->showField(Text::_('JFIELD_ORDERING_LABEL'), $input);
	}
	?>
	
	<div class="form-actions">
		<button type="button" onclick="Joomla.submitbutton('predefinedsearch.save');" class="btn btn-primary"><?php echo Text::_('RST_SAVE'); ?></button>
		<a href="<?php echo RSTicketsProHelper::route('index.php?option=com_rsticketspro&view=predefinedsearches'); ?>" class="btn btn-secondary"><?php echo Text::_('RST_BACK_TO_SEARCHES_LIST'); ?></a>
	</div>
	
	<div>
		<?php echo HTMLHelper::_('form.token'); ?>
		<input type="hidden" name="task" value="" />
	</div>
</form>