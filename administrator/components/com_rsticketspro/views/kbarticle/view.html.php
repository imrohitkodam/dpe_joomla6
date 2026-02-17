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

class RsticketsproViewKbarticle extends HtmlView
{
	protected $form;
	protected $item;
	protected $ticket;
	
	public function display($tpl = null)
	{
		Factory::getApplication()->getInput()->set('hidemainmenu', true);

		$this->addToolbar();
		
		$this->form	  = $this->get('Form');
		$this->item	  = $this->get('Item');
		$this->ticket = $this->get('Ticket');
		
		parent::display($tpl);
	}
	
	protected function addToolbar()
	{
		// set title
		\Joomla\CMS\Toolbar\ToolbarHelper::title('RSTickets! Pro', 'rsticketspro');

		RSTicketsProToolbarHelper::addToolbar('kbarticles');
		
		\Joomla\CMS\Toolbar\ToolbarHelper::apply('kbarticle.apply');
		\Joomla\CMS\Toolbar\ToolbarHelper::save('kbarticle.save');
		\Joomla\CMS\Toolbar\ToolbarHelper::save2new('kbarticle.save2new');
		\Joomla\CMS\Toolbar\ToolbarHelper::save2copy('kbarticle.save2copy');
		\Joomla\CMS\Toolbar\ToolbarHelper::cancel('kbarticle.cancel');
	}
}