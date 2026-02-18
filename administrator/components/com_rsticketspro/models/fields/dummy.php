<?php
/**
 * @package    RSTickets! Pro
 *
 * @copyright  (c) 2010 - 2016 RSJoomla!
 * @link       https://www.rsjoomla.com
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl-3.0.en.html
 */

defined('JPATH_PLATFORM') or die;

\Joomla\CMS\Form\FormHelper::loadFieldClass('hidden');

class JFormFieldDummy extends \Joomla\CMS\Form\Field\HiddenField
{
	protected $type = 'Dummy';
	
	protected function getInput()
	{
		return '';
	}
}