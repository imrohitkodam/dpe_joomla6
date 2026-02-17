<?php
/**
 * @package    RSTickets! Pro
 *
 * @copyright  (c) 2010 - 2016 RSJoomla!
 * @link       https://www.rsjoomla.com
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl-3.0.en.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\Model\BaseDatabaseModel;

use Joomla\CMS\Router\Route;

use Joomla\CMS\Language\Text;

use Joomla\CMS\Factory;

class RsticketsproModelRsticketspro extends BaseDatabaseModel
{
	public function getCode()
	{
		return RSTicketsProConfig::getInstance()->get('global_register_code');
	}

	public function getKbbuttons()
	{
		Factory::getLanguage()->load('com_rsticketspro.sys', JPATH_ADMINISTRATOR);

		$buttons = array(
			array(
				'link' => Route::_('index.php?option=com_rsticketspro&view=kbcategories'),
				'icon' => 'briefcase',
				'text' => Text::_('COM_RSTICKETSPRO_KB_CATEGORIES'),
				'access' => true,
				'target' => ''
			),
			array(
				'link' => Route::_('index.php?option=com_rsticketspro&view=kbarticles'),
				'icon' => 'doc-text',
				'text' => Text::_('COM_RSTICKETSPRO_KB_ARTICLES'),
				'access' => true,
				'target' => ''
			),
			array(
				'link' => Route::_('index.php?option=com_rsticketspro&view=kbrules'),
				'icon' => 'magic',
				'text' => Text::_('COM_RSTICKETSPRO_KB_CONVERSION_RULES'),
				'access' => true,
				'target' => ''
			)
		);

		return $buttons;
	}
	
	public function getButtons()
	{
		Factory::getLanguage()->load('com_rsticketspro.sys', JPATH_ADMINISTRATOR);
		
		$buttons = array(
			array(
				'link' => Route::_('index.php?option=com_rsticketspro&view=tickets'),
				'icon' => 'clipboard',
				'text' => Text::_('COM_RSTICKETSPRO_MANAGE_TICKETS'),
				'access' => true,
				'target' => ''
			),
			array(
				'link' => Route::_('index.php?option=com_rsticketspro&view=departments'),
				'icon' => 'folder',
				'text' => Text::_('COM_RSTICKETSPRO_DEPARTMENTS'),
				'access' => true,
				'target' => ''
			),
			array(
				'link' => Route::_('index.php?option=com_rsticketspro&view=groups'),
				'icon' => 'users',
				'text' => Text::_('COM_RSTICKETSPRO_GROUPS'),
				'access' => true,
				'target' => ''
			),
			array(
				'link' => Route::_('index.php?option=com_rsticketspro&view=staffs'),
				'icon' => 'user',
				'text' => Text::_('COM_RSTICKETSPRO_STAFF_MEMBERS'),
				'access' => true,
				'target' => ''
			),
			array(
				'link' => Route::_('index.php?option=com_rsticketspro&view=priorities'),
				'icon' => 'chart-bar',
				'text' => Text::_('COM_RSTICKETSPRO_PRIORITIES'),
				'access' => true,
				'target' => ''
			),
			array(
				'link' => Route::_('index.php?option=com_rsticketspro&view=statuses'),
				'icon' => 'arrows-cw',
				'text' => Text::_('COM_RSTICKETSPRO_STATUSES'),
				'access' => true,
				'target' => ''
			),
			array(
				'link' => Route::_('index.php?option=com_rsticketspro&view=emails'),
				'icon' => 'mail',
				'text' => Text::_('COM_RSTICKETSPRO_EMAIL_MESSAGES'),
				'access' => true,
				'target' => ''
			),
			array(
				'link' => Route::_('index.php?option=com_rsticketspro&view=configuration'),
				'icon' => 'cogs',
				'text' => Text::_('COM_RSTICKETSPRO_CONFIGURATION'),
				'access' => Factory::getUser()->authorise('core.admin', 'com_rsticketspro'),
				'target' => ''
			),
			array(
				'link' => Route::_('https://www.rsjoomla.com/support.html'),
				'icon' => 'lifebuoy',
				'text' => Text::_('RST_GET_SUPPORT'),
				'access' => true,
				'target' => '_blank'
			)
		);
		
		Factory::getApplication()->triggerEvent('onAfterTicketsOverview', array(array('buttons' => &$buttons)));
		
		return $buttons;
	}
}