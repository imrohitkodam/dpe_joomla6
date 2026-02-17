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

use Joomla\CMS\Factory;

class RsticketsproViewDepartment extends HtmlView
{
	protected $form;
	protected $item;
	protected $tabs;
	protected $php_values;
	
	public function display($tpl = null)
	{
		Factory::getApplication()->getInput()->set('hidemainmenu', true);

		$this->addToolbar();

		$this->form			= $this->get('Form');
		$this->item			= $this->get('Item');
		$this->tabs	 		= $this->get('RSTabs');
		$this->php_values 	= $this->get('PHPValues');
		
		parent::display($tpl);
	}
	
	protected function addToolbar()
	{
		// set title
		\Joomla\CMS\Toolbar\ToolbarHelper::title('RSTickets! Pro', 'rsticketspro');

		RSTicketsProToolbarHelper::addToolbar('departments');
		
		\Joomla\CMS\Toolbar\ToolbarHelper::apply('department.apply');
		\Joomla\CMS\Toolbar\ToolbarHelper::save('department.save');
		\Joomla\CMS\Toolbar\ToolbarHelper::save2new('department.save2new');
		\Joomla\CMS\Toolbar\ToolbarHelper::save2copy('department.save2copy');
		\Joomla\CMS\Toolbar\ToolbarHelper::cancel('department.cancel');
	}
}