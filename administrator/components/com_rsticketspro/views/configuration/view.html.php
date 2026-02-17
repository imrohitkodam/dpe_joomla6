<?php
/**
 * @package    RSTickets! Pro
 *
 * @copyright  (c) 2010 - 2016 RSJoomla!
 * @link       https://www.rsjoomla.com
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl-3.0.en.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\View\HtmlView;

use Joomla\CMS\Router\Route;

use Joomla\CMS\Language\Text;

use Joomla\CMS\Factory;

class RsticketsproViewConfiguration extends HtmlView
{
	protected $tabs;
	protected $field;
	protected $form;
	protected $fieldsets;
	protected $config;
	protected $sidebar;
	
	public function display($tpl = null)
	{
		$user = Factory::getUser();

		if (!$user->authorise('core.admin', 'com_rsticketspro')) {
			$app = Factory::getApplication();
			$app->enqueueMessage(Text::_('JERROR_ALERTNOAUTHOR'), 'error');
			$app->redirect(Route::_('index.php?option=com_rsticketspro', false));
		}
		
		$this->addToolbar();

		$this->tabs		 = $this->get('RSTabs');
		$this->form		 = $this->get('Form');
		$this->fieldsets = $this->form->getFieldsets();

		if (!RSTicketsProHelper::cronPluginExists())
		{
			$this->form->setFieldAttribute('show_alternative_email', 'type', 'hidden');
		}
		
		// config
		$this->config	= $this->get('Config');
		
		parent::display($tpl);
	}
	
	protected function addToolbar() {
		// set title
		\Joomla\CMS\Toolbar\ToolbarHelper::title('RSTickets! Pro', 'rsticketspro');

		RSTicketsProToolbarHelper::addToolbar('configuration');
		
		\Joomla\CMS\Toolbar\ToolbarHelper::apply('configuration.apply');
		\Joomla\CMS\Toolbar\ToolbarHelper::save('configuration.save');
		\Joomla\CMS\Toolbar\ToolbarHelper::cancel('configuration.cancel');
	}
}