<?php
/**
 * @package    RSTickets! Pro
 *
 * @copyright  (c) 2010 - 2016 RSJoomla!
 * @link       https://www.rsjoomla.com
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl-3.0.en.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Router\Route;

use Joomla\CMS\Factory;

class RsticketsproControllerNotes extends JControllerAdmin
{
	public function getModel($name = 'Note', $prefix = 'RsticketsproModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function delete()
	{
		parent::delete();

		$this->setRedirect(Route::_('index.php?option=' . $this->option . '&view=' . $this->view_list . '&ticket_id=' . Factory::getApplication()->getInput()->getInt('ticket_id') . '&tmpl=component', false));
	}
}