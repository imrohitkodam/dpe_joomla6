<?php
/**
 * @package    RSTickets! Pro
 *
 * @copyright  (c) 2010 - 2016 RSJoomla!
 * @link       https://www.rsjoomla.com
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl-3.0.en.html
 */
defined('JPATH_PLATFORM') or die;

\Joomla\CMS\Form\FormHelper::loadFieldClass('list');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

class JFormFieldPriorities extends \Joomla\CMS\Form\Field\ListField
{
	protected $type = 'Priorities';
	
	protected function getOptions()
	{
		// Initialize variables.
		$options = parent::getOptions();
		
		if (isset($this->element['please']) && $this->element['please'] == 'true')
		{
			$options[] = HTMLHelper::_('select.option', '', Text::_('RST_PLEASE_SELECT_PRIORITY'));
		}
		
		if (isset($this->element['all']) && $this->element['all'] == 'true')
		{
			$options[] = HTMLHelper::_('select.option', 0, Text::_('RST_ALL_PRIORITIES'));
		}
		
		$db 	= Factory::getDbo();
		$query 	= $db->getQuery(true);
		$query->select($db->qn('id'))
			  ->select($db->qn('name'))
			  ->from('#__rsticketspro_priorities');
		
		if (isset($this->element['published']) && $this->element['published'] == 'true')
		{
			$query->where($db->qn('published').'='.$db->q(1));
		}
		
		$query->order($db->qn('ordering').' '.$db->escape('asc'));
		$db->setQuery($query);
		
		$priorities = $db->loadObjectList();
		foreach ($priorities as $priority)
		{
			// Add the option object to the result set.
			$options[] = HTMLHelper::_('select.option', $priority->id, Text::_($priority->name));
		}

		reset($options);
		
		return $options;
	}
}