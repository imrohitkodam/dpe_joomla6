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

use Joomla\CMS\Session\Session;
use Joomla\CMS\Factory;

class RsticketsproControllerConfiguration extends BaseController
{
    public function __construct($config = array())
    {
		parent::__construct($config);
		
		$user = Factory::getUser();
		if (!$user->authorise('core.admin', 'com_rsticketspro'))
		{
			$app = Factory::getApplication();
			$app->enqueueMessage(Text::_('JERROR_ALERTNOAUTHOR'), 'error');
			$app->redirect(Route::_('index.php?option=com_rsticketspro', false));
		}
		
		$this->registerTask('apply', 'save');
	}
	
	public function cancel()
	{
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));
		
		$this->setRedirect(Route::_('index.php?option=com_rsticketspro', false));
	}
	
	public function save()
	{
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));

        $app   = Factory::getApplication();
		$input = $app->input;
		$data  = $input->get('jform', array(), 'array');
		$model = $this->getModel('configuration');
		$form  = $model->getForm();

		// Validate the posted data.
		$return = $model->validate($form, $data);
		
		// Check for validation errors.
		if ($return === false)
		{
			// Get the validation messages.
			$errors = $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
			{
				if ($errors[$i] instanceof Exception)
				{
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				}
				else
				{
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			// Redirect back to the edit screen.
			$this->setRedirect(Route::_('index.php?option=com_rsticketspro&view=configuration', false));
			return false;
		}

		$data = $return;
		
		if (!$model->save($data))
		{
			$this->setMessage($model->getError(), 'error');
		}
		else
		{
			$this->setMessage(Text::_('RST_CONFIGURATION_OK', 'info'));
		}
		
		$task = $this->getTask();
		if ($task == 'save')
		{
			$this->setRedirect(Route::_('index.php?option=com_rsticketspro', false));
		}
		elseif ($task == 'apply')
		{
			$this->setRedirect(Route::_('index.php?option=com_rsticketspro&view=configuration', false));
		}
	}
}