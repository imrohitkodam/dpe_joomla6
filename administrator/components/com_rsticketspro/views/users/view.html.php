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

use Joomla\CMS\Uri\Uri;

use Joomla\CMS\Router\Route;

use Joomla\CMS\Language\Text;

use Joomla\CMS\Factory;

class RsticketsproViewUsers extends HtmlView
{
	protected $items;
	protected $pagination;
	protected $state;

	public function display($tpl = null)
	{
		$this->checkPermissions();

		$this->items		 = $this->get('Items');
		$this->pagination	 = $this->get('Pagination');
		$this->state		 = $this->get('State');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');
		$this->field		 = $this->get('Field');

		parent::display($tpl);
	}

	protected function checkPermissions()
	{
		$user = Factory::getUser();
		$app  = Factory::getApplication();

		// not logged in?
		if (!$user->get('id'))
		{
			$app->redirect(Route::_('index.php?option=com_users&view=login&return=' . base64_encode((string) Uri::getInstance()), false));
		}

		// check permissions
		$permissions = RSTicketsProHelper::getCurrentPermissions();
		if (!RSTicketsProHelper::isStaff() || !$permissions || (!$permissions->add_ticket_customers && !$permissions->add_ticket_staff))
		{
			throw new Exception(Text::_('RST_STAFF_CANNOT_VIEW_USERS'), 403);
		}
	}
}