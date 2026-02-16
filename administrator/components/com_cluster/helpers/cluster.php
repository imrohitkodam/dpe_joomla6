<?php
/**
 * @package    Cluster
 *
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (C) 2009 - 2018 Techjoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\Filesystem\Path;

use Joomla\CMS\Factory;

/**
 * Cluster helper.
 *
 * @since  1.0.0
 */
class ClusterHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  view name string
	 *
	 * @return void
	 * 
	 * @note JHtmlSidebar has been removed in Joomla 6.
	 *       Submenu is now configured in the component manifest (cluster.xml)
	 *       However, custom client integration logic is preserved below.
	 */
	public static function addSubmenu($vName = '')
	{
		$app = Factory::getApplication();
		$layout = $app->getInput()->get('layout', '', 'STRING');

		// JHtmlSidebar has been removed in Joomla 6
		// The default submenu entries are now configured in cluster.xml
		// This section is kept for backward compatibility but sidebar calls are removed
		
		if ($layout == "default")
		{
			// DPE Custom Code: Client integration for parent component menu
			$client = $app->getInput()->get('client', '', 'STRING');

			// Set ordering.
			$fullClient = explode('.', $client);

			// Eg com_jgive
			$component = $fullClient[0];
			$eName = str_replace('com_', '', $component);
			$file = Path::clean(JPATH_ADMINISTRATOR . '/components/' . $component . '/helpers/' . $eName . '.php');

			if (file_exists($file))
			{
				require_once $file;

				$prefix = ucfirst(str_replace('com_', '', $component));
				$cName = $prefix . 'Helper';

				if (class_exists($cName))
				{
					if (is_callable(array($cName, 'addSubmenu')))
					{
						$lang = Factory::getLanguage();

						// Loading language file from the administrator/language directory then
						// Loading language file from the administrator/components/*extension*/language directory
						$lang->load($component, JPATH_BASE, null, false, false)
						|| $lang->load($component, Path::clean(JPATH_ADMINISTRATOR . '/components/' . $component), null, false, false)
						|| $lang->load($component, JPATH_BASE, $lang->getDefault(), false, false)
						|| $lang->load($component, Path::clean(JPATH_ADMINISTRATOR . '/components/' . $component), $lang->getDefault(), false, false);

						call_user_func(array($cName, 'addSubmenu'), $vName);
					}
				}
			}
		}
	}
}
