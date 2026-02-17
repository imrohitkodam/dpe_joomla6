<?php
/**
 * @package    RSTickets! Pro
 *
 * @copyright  (c) 2010 - 2016 RSJoomla!
 * @link       https://www.rsjoomla.com
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl-3.0.en.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\Controller\BaseController;

use Joomla\CMS\HTML\HTMLHelper;

use Joomla\CMS\Language\Text;

use Joomla\CMS\Factory;

// Access check.
$user = Factory::getUser();
if (!$user->authorise('core.manage', 'com_rsticketspro'))
{
    throw new Exception(Text::_('JERROR_ALERTNOAUTHOR'), 403);
}

$lang = Factory::getLanguage();

// load frontend
$lang->load('com_rsticketspro', JPATH_SITE, 'en-GB', true);
$lang->load('com_rsticketspro', JPATH_SITE, $lang->getDefault(), true);
$lang->load('com_rsticketspro', JPATH_SITE, null, true);

// load backend
$lang->load('com_rsticketspro', JPATH_ADMINISTRATOR, 'en-GB', true);
$lang->load('com_rsticketspro', JPATH_ADMINISTRATOR, $lang->getDefault(), true);
$lang->load('com_rsticketspro', JPATH_ADMINISTRATOR, null, true);

// Require helper files
require_once __DIR__ . '/helpers/adapter.php';
require_once __DIR__ . '/helpers/rsticketspro.php';
require_once __DIR__ . '/helpers/toolbar.php';

HTMLHelper::_('jquery.framework', true);
HTMLHelper::_('stylesheet', 'com_rsticketspro/rsticketspro.css', array('relative' => true, 'version' => 'auto'));
HTMLHelper::_('stylesheet', 'com_rsticketspro/icons.css', array('relative' => true, 'version' => 'auto'));
HTMLHelper::_('script', 'com_rsticketspro/rsticketspro.js', array('relative' => true, 'version' => 'auto'));

if (version_compare(JVERSION, '4.0', '>='))
{
	HTMLHelper::_('stylesheet', 'com_rsticketspro/style40.css', array('relative' => true, 'version' => 'auto'));
}
else
{
	HTMLHelper::_('stylesheet', 'com_rsticketspro/style30.css', array('relative' => true, 'version' => 'auto'));
}

// Require the base controller
require_once __DIR__ . '/controller.php';

$controller	= BaseController::getInstance('Rsticketspro');
$task = Factory::getApplication()->getInput()->get('task');
$controller->execute($task);
$controller->redirect();