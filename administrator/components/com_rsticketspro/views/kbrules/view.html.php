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

class RsticketsproViewKbrules extends HtmlView
{
	protected $items;
	protected $pagination;
	protected $state;
	
	public function display($tpl = null)
	{
		$this->addToolbar();

		$this->items 		 = $this->get('Items');
		$this->pagination 	 = $this->get('Pagination');
		$this->state 		 = $this->get('State');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');
		
		parent::display($tpl);
	}
	
	protected function addToolbar()
	{
		// set title
		\Joomla\CMS\Toolbar\ToolbarHelper::title('RSTickets! Pro', 'rsticketspro');

		RSTicketsProToolbarHelper::addToolbar('kbrules');

		$user = Factory::getUser();

		if ($user->authorise('kbrule.create', 'com_rsticketspro'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::addNew('kbrule.add');
		}
		if ($user->authorise('kbrule.edit', 'com_rsticketspro'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::editList('kbrule.edit');
		}
		if ($user->authorise('kbrule.edit.state', 'com_rsticketspro'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::publish('kbrules.publish', 'JTOOLBAR_PUBLISH', true);
			\Joomla\CMS\Toolbar\ToolbarHelper::unpublish('kbrules.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		}
		if ($user->authorise('kbrule.delete', 'com_rsticketspro'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::deleteList('RST_CONFIRM_DELETE', 'kbrules.delete');
		}
	}
}