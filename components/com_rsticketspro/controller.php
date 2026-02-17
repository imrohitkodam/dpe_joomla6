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

use Joomla\Filesystem\Folder;

use Joomla\Filesystem\File;

use Joomla\CMS\Language\Text;

use Joomla\CMS\Factory;

class RsticketsproController extends BaseController
{
	public function captcha()
	{
		if (RSTicketsProHelper::getConfig('captcha_enabled') == 1)
		{
			require_once JPATH_ADMINISTRATOR . '/components/com_rsticketspro/helpers/captcha/captcha.php';
			$captcha = new RsticketsproCaptcha;
			
			$captcha->setLength(RSTicketsProHelper::getConfig('captcha_characters'));
			
			ob_end_clean();

			$captcha->getImage();

			Factory::getApplication()->setHeader('content-type', 'image/jpeg');
			Factory::getApplication()->sendHeaders();
		}

		Factory::getApplication()->close();
	}
	
	public function resetsearch()
	{
		$model = $this->getModel('tickets');
		$model->resetSearch();
		
		$this->setRedirect(RSTicketsProHelper::route('index.php?option=com_rsticketspro&view=tickets', false));
	}
	
	public function cron()
	{
		if (file_exists(JPATH_ADMINISTRATOR.'/components/com_rsticketspro/helpers/cron.php'))
		{
			require_once JPATH_ADMINISTRATOR.'/components/com_rsticketspro/helpers/cron.php';
			
			$types 	= array(1,2);
			$cron 	= new RSTicketsProCron($types);
			
			$cron->parse();
		}
	}
	
	public function viewinline()
	{
		try
		{
			$db			 = Factory::getDbo();
			$query		 = $db->getQuery(true);
			$app		 = Factory::getApplication();
			$user		 = Factory::getUser();
			$filename	 = $app->getInput()->getString('filename','');
			$ticket_id	 = $app->getInput()->getInt('cid',0);
			$is_staff	 = RSTicketsProHelper::isStaff();
			$permissions = RSTicketsProHelper::getCurrentPermissions();
			$departments = RSTicketsProHelper::getCurrentDepartments();

			$query->select($db->qn('customer_id'))
				->select($db->qn('department_id'))
				->select($db->qn('staff_id'))
				->from($db->qn('#__rsticketspro_tickets'))
				->where($db->qn('id') .' = ' . $db->q($ticket_id));

			$ticket = $db->setQuery($query)->loadObject();

			if (!$ticket)
			{
				throw new Exception(Text::_('RST_CUSTOMER_CANNOT_VIEW_TICKET'));
			}

			// Check for permissions
			if (!$is_staff && $ticket->customer_id != $user->get('id'))
			{
				throw new Exception(Text::_('RST_CUSTOMER_CANNOT_VIEW_TICKET'));
			}

			if ($is_staff)
			{
				// Staff - check if belongs to department only if he is not the customer
				if ($ticket->customer_id != $user->get('id') && !in_array($ticket->department_id, $departments))
				{
					throw new Exception(Text::_('RST_STAFF_CANNOT_VIEW_TICKET'));
				}

				if (RSTicketsProHelper::getConfig('staff_force_departments') && !in_array($ticket->department_id, $departments))
				{
					throw new Exception(Text::_('RST_STAFF_CANNOT_VIEW_TICKET'));
				}

				if (!$permissions->see_unassigned_tickets && $ticket->staff_id == 0)
				{
					throw new Exception(Text::_('RST_STAFF_CANNOT_VIEW_TICKET'));
				}

				if (!$permissions->see_other_tickets && $ticket->staff_id > 0 && $ticket->staff_id != $user->get('id'))
				{
					throw new Exception(Text::_('RST_STAFF_CANNOT_VIEW_TICKET'));
				}
			}

			$query->clear()
				->select('*')
				->from($db->qn('#__rsticketspro_ticket_files'))
				->where($db->qn('ticket_id') . ' = ' . $db->q($ticket_id))
				->where($db->qn('filename') . ' = ' . $db->q($filename));

			$file = $db->setQuery($query)->loadObject();

			if (empty($file))
			{
				throw new Exception(Text::_('RST_CANNOT_DOWNLOAD_FILE'));
			}

			$hash = md5($file->id . ' ' . $file->ticket_message_id);
			$path = RST_UPLOAD_FOLDER . '/' . $hash;

			if (!file_exists($path))
			{
				throw new Exception(Text::_('RST_CANNOT_DOWNLOAD_FILE_NOT_EXIST'));
			}

			$extension = strtolower(File::getExt($file->filename));
			$images    = array('jpg', 'jpeg', 'gif', 'png');
			if (in_array($extension, $images))
			{
				if ($extension === 'jpg')
				{
					$extension = 'jpeg';
				}

				header('Content-Type: image/'.$extension);
			}

			@ob_end_clean();

			header("Cache-Control: public, must-revalidate");
			header('Cache-Control: pre-check=0, post-check=0, max-age=0');
			header("Cache-Control: no-cache");
			header("Pragma: no-cache");
			header("Expires: 0");
			header("Content-Description: File Transfer");
			header("Expires: Sat, 01 Jan 2000 01:00:00 GMT");
			header("Content-Length: " . (string) filesize($path));
			header('Content-Disposition: inline; filename="' . $file->filename . '"');
			header("Content-Transfer-Encoding: binary\n");

			readfile($path);

			$app->close();
		}
		catch (Exception $e)
		{
			$app->enqueueMessage($e->getMessage(), 'warning');
			$app->redirect(RSTicketsProHelper::route('index.php?option=com_rsticketspro&view=tickets', false));
		}
	}

	public function display($cachable = false, $urlparams = array())
	{
		$app = Factory::getApplication();

		if ($app->isClient('site'))
		{
			$vName	= $app->getInput()->getCmd('view', '');
			$allowed = Folder::folders(__DIR__ . '/views');

			if (!in_array($vName, $allowed))
			{
				$app->getInput()->set('view', 'tickets');
			}
		}

		parent::display($cachable, $urlparams);
	}
	
	public function sendfeedback() {
		$this->checkToken();

		$model	= $this->getModel('article');
		$app	= Factory::getApplication();
		$cid	= $app->getInput()->getInt('cid');

		$data = array(
			'cid'               => $cid,
			'user_id'           => Factory::getUser()->id,
			'ip'                => \Joomla\Utilities\IpHelper::getIp(),
			'date_submitted'    => Factory::getDate()->toSql()
		);
		
		if (!RSTicketsProHelper::UserPostedFeedback($cid)) {
			$model->sendfeedback($data);
			$check = array('valid' => true, 'message' => Text::_('RST_KB_ARTICLE_FEEDBACK_MESSAGE_SUCCESS'));
		} else {
			$check = array('valid' => false, 'message' => Text::_('RST_KB_ARTICLE_FEEDBACK_MESSAGE_ALREADY_POSTED_ERROR'));
		}
		
		echo json_encode($check);
		die;
	}
}