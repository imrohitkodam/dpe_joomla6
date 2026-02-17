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

use Joomla\CMS\Language\Text;

use Joomla\CMS\Factory;

class RsticketsproViewSearch extends HtmlView
{
	protected $form;
	
	public function display($tpl = null)
	{
		Factory::getApplication()->getInput()->set('hidemainmenu', true);

		$this->addToolbar();

		$this->form	= $this->get('Form');
		
		parent::display($tpl);
	}
	
	protected function addToolbar()
	{
		// set title
		\Joomla\CMS\Toolbar\ToolbarHelper::title('RSTickets! Pro', 'rsticketspro');

		RSTicketsProToolbarHelper::addToolbar('tickets');
		
		\Joomla\CMS\Toolbar\ToolbarHelper::custom('search.perform', 'search', 'search', Text::_('RST_SEARCH'), false);
		\Joomla\CMS\Toolbar\ToolbarHelper::cancel('search.cancel');
	}
}