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

class RsticketsproViewPriorities extends HtmlView
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

		RSTicketsProToolbarHelper::addToolbar('priorities');

		$user = Factory::getUser();

		if ($user->authorise('priority.create', 'com_rsticketspro'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::addNew('priority.add');
		}
		if ($user->authorise('priority.edit', 'com_rsticketspro'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::editList('priority.edit');
		}
		if ($user->authorise('priority.edit.state', 'com_rsticketspro'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::publish('priorities.publish', 'JTOOLBAR_PUBLISH', true);
			\Joomla\CMS\Toolbar\ToolbarHelper::unpublish('priorities.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		}
		if ($user->authorise('priority.delete', 'com_rsticketspro'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::deleteList('RST_CONFIRM_DELETE', 'priorities.delete');
		}
	}
}