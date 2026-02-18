<?php
/**
 * @package    RSTickets! Pro
 *
 * @copyright  (c) 2010 - 2016 RSJoomla!
 * @link       https://www.rsjoomla.com
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl-3.0.en.html
 */

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

\Joomla\CMS\Form\FormHelper::loadFieldClass('text');

class JFormFieldTypeahead extends \Joomla\CMS\Form\FormFieldText
{
	protected function getInput()
	{
		HTMLHelper::_('stylesheet', 'com_rsticketspro/awesomplete.css', array('relative' => true, 'version' => 'auto'));
		HTMLHelper::_('script', 'com_rsticketspro/awesomplete.min.js', array('relative' => true, 'version' => 'auto'));
		HTMLHelper::_('script', 'com_rsticketspro/awesomplete.script.js', array('relative' => true, 'version' => 'auto'));

		$id = json_encode($this->id);
		$messageboxId = json_encode($this->getAttribute('messagebox'));

		$allowEditor = RSTicketsProHelper::getConfig('allow_rich_editor');
		Factory::getDocument()->addScriptDeclaration("initAwesomplete({$id}, $allowEditor, {$messageboxId});");

		return parent::getInput();
	}
}