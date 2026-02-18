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

class JFormFieldComments extends \Joomla\CMS\Form\Field\ListField
{
	protected $type = 'Comments';
	
	protected function getOptions()
	{
		// Initialize variables.
		$options = array();
		
		$db 	= Factory::getDbo();
		$query 	= $db->getQuery(true);

		$components = array(
			'RSComments!' => 'com_rscomments',
			'JComments' => 'com_jcomments',
			'JomComment' => 'com_jomcomment'
		);

		$query->select('element')
			->from('#__extensions')
			->where($db->qn('type').'='.$db->q('component'))
			->where($db->qn('element').' IN (' . implode(',', $db->q($components)) . ')');
		$available = $db->setQuery($query)->loadColumn();
		
		$options[] = HTMLHelper::_('select.option', '0', Text::_('RST_KB_COMMENTS_DISABLED'));
		$options[] = HTMLHelper::_('select.option', 'facebook', Text::_('RST_FACEBOOK_COMMENTS'));
		
		foreach ($components as $name => $component)
		{
			$disabled = !in_array($component, $available);
			$options[] = HTMLHelper::_('select.option', $component, $name, 'value', 'text', $disabled);
		}
		
		reset($options);
		
		return $options;
	}
}
