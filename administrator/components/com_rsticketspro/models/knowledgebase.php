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

class RsticketsproModelKnowledgebase extends BaseDatabaseModel
{
	protected $config;
	
	public function __construct() {
		parent::__construct();
		
		$this->config = RSTicketsProConfig::getInstance();
	}
	
	public function getCode() {
		return $this->config->get('global_register_code');
	}
	
	public function getSideBar() {
		require_once JPATH_COMPONENT.'/helpers/toolbar.php';
		
		return RSTicketsProToolbarHelper::render();
	}
	
	public function getButtons() {
		Factory::getLanguage()->load('com_rsticketspro.sys', JPATH_ADMINISTRATOR);
		
		/* $button = array(
				'access', 'id', 'link', 'target', 'onclick', 'title', 'image', 'alt', 'text'
			); */
		
		$buttons = array(
			array(
				'link' => Route::_('index.php?option=com_rsticketspro'),
				'image' =>'com_rsticketspro/admin/dashboard/back.png',
				'text' => Text::_('COM_RSTICKETSPRO_BACK_TO_RSTICKETSPRO'),
				'access' => true
			),
			array(
				'link' => Route::_('index.php?option=com_rsticketspro&view=kbcategories'),
				'image' =>'com_rsticketspro/admin/dashboard/kbcategories.png',
				'text' => Text::_('COM_RSTICKETSPRO_KB_CATEGORIES'),
				'access' => true
			),
			array(
				'link' => Route::_('index.php?option=com_rsticketspro&view=kbarticles'),
				'image' =>'com_rsticketspro/admin/dashboard/kbcontent.png',
				'text' => Text::_('COM_RSTICKETSPRO_KB_ARTICLES'),
				'access' => true
			),
			array(
				'link' => Route::_('index.php?option=com_rsticketspro&view=kbrules'),
				'image' =>'com_rsticketspro/admin/dashboard/kbrules.png',
				'text' => Text::_('COM_RSTICKETSPRO_KB_CONVERSION_RULES'),
				'access' => true
			),
			array(
				'link' => Route::_('index.php?option=com_rsticketspro&view=kbtemplate'),
				'image' =>'com_rsticketspro/admin/dashboard/kbtemplate.png',
				'text' => Text::_('COM_RSTICKETSPRO_KB_TEMPLATE'),
				'access' => true
			)
		);
		
		return $buttons;
	}
	
	public function getLongVersion() {
		$version = new RSTicketsProVersion();
		return $version->long;
	}
	
	public function getRevision() {
		$version = new RSTicketsProVersion();
		return $version->revision;
	}
}