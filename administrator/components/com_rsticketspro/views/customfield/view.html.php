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

class RsticketsproViewCustomfield extends HtmlView
{
	protected $form;
	protected $item;
	protected $field;
	
	public function display($tpl = null)
	{
		Factory::getApplication()->getInput()->set('hidemainmenu', true);

		$this->addToolbar();
		
		$this->form	= $this->get('Form');
		$this->item	= $this->get('Item');
		
		parent::display($tpl);
	}
	
	protected function addToolbar()
	{
		// set title
		\Joomla\CMS\Toolbar\ToolbarHelper::title('RSTickets! Pro', 'rsticketspro');

		RSTicketsProToolbarHelper::addToolbar('customfields');
		
		\Joomla\CMS\Toolbar\ToolbarHelper::apply('customfield.apply');
		\Joomla\CMS\Toolbar\ToolbarHelper::save('customfield.save');
		\Joomla\CMS\Toolbar\ToolbarHelper::save2new('customfield.save2new');
		\Joomla\CMS\Toolbar\ToolbarHelper::save2copy('customfield.save2copy');
		\Joomla\CMS\Toolbar\ToolbarHelper::cancel('customfield.cancel');
	}
}