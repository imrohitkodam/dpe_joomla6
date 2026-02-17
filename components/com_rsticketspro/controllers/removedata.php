<?php
/**
 * @package    RSTickets! Pro
 *
 * @copyright  (c) 2010 - 2018 RSJoomla!
 * @link       https://www.rsjoomla.com
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl-3.0.en.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\Controller\BaseController;

use Joomla\CMS\Uri\Uri;

use Joomla\CMS\Router\Route;

use Joomla\CMS\Language\Text;

use Joomla\CMS\Factory;

class RsticketsproControllerRemovedata extends BaseController
{
    public function request()
    {
        JSession::checkToken() or jexit('Invalid Token');

        try
        {
            $user = Factory::getUser();
            if ($user->guest)
            {
                throw new Exception(Text::_('COM_RSTICKETSPRO_MUST_BE_LOGGED_IN'));
            }

            if (!RSTicketsProHelper::getConfig('allow_self_anonymisation'))
            {
                throw new Exception(Text::_('COM_RSTICKETSPRO_THIS_FEATURE_MUST_BE_ENABLED'));
            }

            if ($user->authorise('core.admin'))
            {
                throw new Exception(Text::_('COM_RSTICKETSPRO_THIS_FEATURE_IS_NOT_AVAILABLE_FOR_SUPER_USERS'));
            }

			$app    = Factory::getApplication();

            // Create a token
            $token = JApplicationHelper::getHash(JUserHelper::genRandomPassword(10));
            $hashedToken = JUserHelper::hashPassword($token);

            // Save the token
            $db = Factory::getDbo();
            $query = $db->getQuery(true)
                ->select('*')
                ->from($db->qn('#__rsticketspro_tokens'))
                ->where($db->qn('user_id') . ' = ' . $db->q($user->id));
            if ($db->setQuery($query)->loadObject())
            {
                $query->clear()
                    ->update($db->qn('#__rsticketspro_tokens'))
                    ->set($db->qn('token') . ' = ' . $db->q($hashedToken))
                    ->where($db->qn('user_id') . ' = ' . $db->q($user->id));
            }
            else
            {
                $query->clear()
                    ->insert($db->qn('#__rsticketspro_tokens'))
                    ->columns(array($db->qn('user_id'), $db->qn('token')))
                    ->values(implode(', ', array($db->q($user->id), $db->q($hashedToken))));
            }

            $db->setQuery($query)->execute();

            // Create the URL
            $uri 	= Uri::getInstance();
            $base	= $uri->toString(array('scheme', 'user', 'pass', 'host', 'port'));
            $url    = $base . Route::_('index.php?option=com_rsticketspro&task=removedata.process&token=' . $token, false);

            Factory::getMailer()->sendMail($app->get('mailfrom'), $app->get('fromname'), $user->email, Text::sprintf('COM_RSTICKETSPRO_REMOVE_REQUEST_EMAIL_SUBJECT', $user->username, $app->get('sitename')), Text::sprintf('COM_RSTICKETSPRO_REMOVE_REQUEST_EMAIL_BODY', $user->name, $url), true, null, null, null, $app->get('replyto'), $app->get('replytoname'));
        }
        catch (Exception $e)
        {
            jexit($e->getMessage());
        }

        jexit(Text::_('COM_RSTICKETSPRO_LINK_HAS_BEEN_SENT'));
    }

    public function process()
    {
        $app    = Factory::getApplication();
        $user   = Factory::getUser();

        try
        {
            if ($user->guest)
            {
                $link = base64_encode((string) Uri::getInstance());
                $app->redirect(Route::_('index.php?option=com_users&view=login&return=' . $link, false), Text::_('COM_RSTICKETSPRO_MUST_BE_LOGGED_IN'));
            }

            if (!RSTicketsProHelper::getConfig('allow_self_anonymisation'))
            {
                throw new Exception(Text::_('COM_RSTICKETSPRO_THIS_FEATURE_MUST_BE_ENABLED'));
            }

            if ($user->authorise('core.admin'))
            {
                throw new Exception(Text::_('COM_RSTICKETSPRO_THIS_FEATURE_IS_NOT_AVAILABLE_FOR_SUPER_USERS'));
            }

            $token = $app->getInput()->getCmd('token');
            if (!$token || strlen($token) != 32)
            {
                throw new Exception(Text::_('COM_RSTICKETSPRO_TOKEN_IS_INCORRECT'));
            }

            // Let's see if the token matches
            $db = Factory::getDbo();
            $query = $db->getQuery(true)
                ->select($db->qn('token'))
                ->from($db->qn('#__rsticketspro_tokens'))
                ->where($db->qn('user_id') . ' = ' . $db->q($user->id));
            $dbToken = $db->setQuery($query)->loadResult();

            if (!$dbToken || !JUserHelper::verifyPassword($token, $dbToken))
            {
                throw new Exception(Text::_('COM_RSTICKETSPRO_TOKEN_IS_INCORRECT'));
            }

            // Delete the token
            $query->clear()
                ->delete($db->qn('#__rsticketspro_tokens'))
                ->where($db->qn('user_id') . ' = ' . $db->q($user->id));
            $db->setQuery($query)->execute();

            // Anonymise data
            RSTicketsProHelper::anonymise($user->id);

            $app->logout();
            $app->redirect(Route::_('index.php?option=com_rsticketspro&view=removedata&layout=success', false));
        }
        catch (Exception $e)
        {
            $app->enqueueMessage($e->getMessage(), 'error');
            $this->setRedirect(Route::_('index.php', false));
        }
    }
}