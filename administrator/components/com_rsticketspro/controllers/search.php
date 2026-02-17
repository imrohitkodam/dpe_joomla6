<?php
/**
 * @package    RSTickets! Pro
 *
 * @copyright  (c) 2010 - 2016 RSJoomla!
 * @link       https://www.rsjoomla.com
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl-3.0.en.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\Controller\BaseController;

use Joomla\CMS\Router\Route;

use Joomla\CMS\Language\Text;

class RsticketsproControllerSearch extends BaseController
{
	public function cancel()
	{
		JSession::checkToken() or jexit(Text::_('JINVALID_TOKEN'));
		
		$this->setRedirect(Route::_('index.php?option=com_rsticketspro&view=tickets', false));
	}
	
	public function reset()
	{
		$model = $this->getModel('tickets');
		$model->resetSearch();
		
		$this->setRedirect(Route::_('index.php?option=com_rsticketspro&view=tickets', false));
	}

	public function advanced()
	{
		$this->setRedirect(Route::_('index.php?option=com_rsticketspro&view=search', false));
	}
}