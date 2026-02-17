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

// Load language
$lang = Factory::getLanguage();
$lang->load('com_rsticketspro', JPATH_SITE, 'en-GB', true);
$lang->load('com_rsticketspro', JPATH_SITE, $lang->getDefault(), true);
$lang->load('com_rsticketspro', JPATH_SITE, null, true);

// Require helper files
require_once JPATH_ADMINISTRATOR . '/components/com_rsticketspro/helpers/adapter.php';
require_once JPATH_ADMINISTRATOR . '/components/com_rsticketspro/helpers/rsticketspro.php';

$lang = Factory::getLanguage();

// load frontend
$lang->load('com_rsticketspro', JPATH_SITE, 'en-GB', true);
$lang->load('com_rsticketspro', JPATH_SITE, $lang->getDefault(), true);
$lang->load('com_rsticketspro', JPATH_SITE, null, true);

// DPE hack to show the language constant

 Text::script('RST_MAX_UPLOAD_FILES_REACHED');
 Text::script('RST_TICKET_ATTACHMENTS');
 Text::script('RST_TICKET_ATTACHMENTS_REQUIRED');
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

if (RSTicketsProHelper::getConfig('jquery'))
{
	HTMLHelper::_('jquery.framework');
}

if (RSTicketsProHelper::getConfig('bootstrap'))
{
	HTMLHelper::_('bootstrap.framework');

	// Load optional rtl Bootstrap css and Bootstrap bugfixes
	HTMLHelper::_('bootstrap.loadCss', $includeMaincss = true, Factory::getDocument()->direction);
}

// Require the base controller
require_once __DIR__ . '/controller.php';

$controller	= BaseController::getInstance('Rsticketspro');
$task = Factory::getApplication()->getInput()->get('task');
$controller->execute($task);
$controller->redirect();