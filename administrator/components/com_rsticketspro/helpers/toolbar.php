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
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\Helpers\Sidebar;

abstract class RSTicketsProToolbarHelper
{
	public static function addToolbar($view = '')
	{
		// load language file (.sys because the toolbar has the same options as the components dropdown)
		Factory::getLanguage()->load('com_rsticketspro.sys', JPATH_ADMINISTRATOR);

		// add toolbar entries
		// overview
		self::addEntry('OVERVIEW', 'index.php?option=com_rsticketspro', $view == '' || $view == 'rsticketspro');
		self::addEntry('MANAGE_TICKETS', 'index.php?option=com_rsticketspro&view=tickets', $view == 'tickets');
		self::addEntry('DEPARTMENTS', 'index.php?option=com_rsticketspro&view=departments', $view == 'departments');
		self::addEntry('CUSTOM_FIELDS', 'index.php?option=com_rsticketspro&view=customfields', $view == 'customfields');
		self::addEntry('GROUPS', 'index.php?option=com_rsticketspro&view=groups', $view == 'groups');
		self::addEntry('STAFF_MEMBERS', 'index.php?option=com_rsticketspro&view=staffs', $view == 'staffs');
		self::addEntry('PRIORITIES', 'index.php?option=com_rsticketspro&view=priorities', $view == 'priorities');
		self::addEntry('STATUSES', 'index.php?option=com_rsticketspro&view=statuses', $view == 'statuses');
		self::addEntry('EMAIL_MESSAGES', 'index.php?option=com_rsticketspro&view=emails', $view == 'emails');
		if (Factory::getUser()->authorise('core.admin', 'com_rsticketspro'))
		{
			self::addEntry('CONFIGURATION', 'index.php?option=com_rsticketspro&view=configuration', $view == 'configuration');
		}
		Factory::getApplication()->triggerEvent('onAfterTicketsMenu');

		self::addEntry('KB_CATEGORIES', 'index.php?option=com_rsticketspro&view=kbcategories', $view == 'kbcategories');
		self::addEntry('KB_ARTICLES', 'index.php?option=com_rsticketspro&view=kbarticles', $view == 'kbarticles');
		self::addEntry('KB_CONVERSION_RULES', 'index.php?option=com_rsticketspro&view=kbrules', $view == 'kbrules');
	}

	public static function addEntry($lang_key, $url, $default = false)
	{
		Sidebar::addEntry(Text::_('COM_RSTICKETSPRO_' . $lang_key), Route::_($url), $default);
	}

	public static function addFilter($text, $key, $options, $noDefault = false)
	{
		Sidebar::addFilter($text, $key, $options, $noDefault);
	}

	public static function render()
	{
		return Sidebar::render();
	}
}