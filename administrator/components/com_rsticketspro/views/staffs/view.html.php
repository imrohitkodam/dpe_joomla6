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

class RsticketsproViewStaffs extends HtmlView
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

		RSTicketsProToolbarHelper::addToolbar('staffs');

		$user = Factory::getUser();

		if ($user->authorise('staff.create', 'com_rsticketspro'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::addNew('staff.add');
		}
		if ($user->authorise('staff.edit', 'com_rsticketspro'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::editList('staff.edit');
		}
		if ($user->authorise('staff.delete', 'com_rsticketspro'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::deleteList('RST_CONFIRM_DELETE', 'staffs.delete');
		}
	}
}