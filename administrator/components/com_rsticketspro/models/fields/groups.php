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

class JFormFieldGroups extends \Joomla\CMS\Form\Field\ListField
{
	protected $type = 'Groups';
	
	protected function getOptions()
	{
		// Initialize variables.
		$options = array();
		
		if (isset($this->element['all']) && $this->element['all'] == 'true')
		{
			$options[] = HTMLHelper::_('select.option', 0, Text::_('RST_ALL_PRIORITIES'));
		}
		
		$db 	= Factory::getDbo();
		$query 	= $db->getQuery(true);
		$query->select($db->qn('id'))
			  ->select($db->qn('name'))
			  ->from('#__rsticketspro_groups');
		$db->setQuery($query);
		
		$groups = $db->loadObjectList();
		foreach ($groups as $group)
		{
			$options[] = HTMLHelper::_('select.option', $group->id, Text::_($group->name));
		}

		reset($options);
		
		return $options;
	}
}