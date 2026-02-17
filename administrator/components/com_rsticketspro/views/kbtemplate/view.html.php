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

class RsticketsproViewKbtemplate extends HtmlView
{
	protected $tabs;
	protected $field;
	protected $form;
	protected $sidebar;
	
	function display($tpl = null) {		
		$this->addToolbar();
		
		// tabs
		$this->tabs		 = $this->get('RSTabs');
		$this->field	 = $this->get('RSFieldset');
		
		// form
		$this->form		 = $this->get('Form');
		
		$this->sidebar	= $this->get('SideBar');
		
		parent::display($tpl);
	}
	
	protected function addToolbar() {
		// set title
		\Joomla\CMS\Toolbar\ToolbarHelper::title('RSTickets! Pro', 'rsticketspro');
		
		require_once JPATH_COMPONENT.'/helpers/toolbar.php';
		RSTicketsProToolbarHelper::addToolbar('kbtemplate');
		
		\Joomla\CMS\Toolbar\ToolbarHelper::apply('kbtemplate.apply');
		\Joomla\CMS\Toolbar\ToolbarHelper::save('kbtemplate.save');
		\Joomla\CMS\Toolbar\ToolbarHelper::cancel('kbtemplate.cancel');
	}
}