<?php
/**
 * @package     Cluster
 * @subpackage  com_cluster
 * @copyright   Copyright (C) 2018 Techjoomla. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Installer\InstallerScript;

/**
 * Cluster component installation script
 *
 * @since  1.0.0
 */
class Com_ClusterInstallerScript extends InstallerScript
{
	/**
	 * Minimum Joomla version required to install the extension
	 *
	 * @var    string
	 * @since  1.0.0
	 */
	protected $minimumJoomla = '4.0';

	/**
	 * Minimum PHP version required to install the extension
	 *
	 * @var    string
	 * @since  1.0.0
	 */
	protected $minimumPhp = '7.4';

	/**
	 * Method to install the extension
	 *
	 * @param   object  $parent  Parent object
	 *
	 * @return  boolean  True on success
	 *
	 * @since   1.0.0
	 */
	public function install($parent)
	{
		return true;
	}

	/**
	 * Method to uninstall the extension
	 *
	 * @param   object  $parent  Parent object
	 *
	 * @return  boolean  True on success
	 *
	 * @since   1.0.0
	 */
	public function uninstall($parent)
	{
		return true;
	}

	/**
	 * Method to update the extension
	 *
	 * @param   object  $parent  Parent object
	 *
	 * @return  boolean  True on success
	 *
	 * @since   1.0.0
	 */
	public function update($parent)
	{
		return true;
	}

	/**
	 * Function called before extension installation/update/removal procedure commences
	 *
	 * @param   string  $type    The type of change (install, update or discover_install, not uninstall)
	 * @param   object  $parent  Parent object
	 *
	 * @return  boolean  True on success
	 *
	 * @since   1.0.0
	 */
	public function preflight($type, $parent)
	{
		// Check minimum Joomla version
		if (!$this->checkJoomlaVersion())
		{
			return false;
		}

		// Check minimum PHP version
		if (!$this->checkPhpVersion())
		{
			return false;
		}

		return true;
	}

	/**
	 * Function called after extension installation/update/removal procedure commences
	 *
	 * @param   string  $type    The type of change (install, update or discover_install, not uninstall)
	 * @param   object  $parent  Parent object
	 *
	 * @return  boolean  True on success
	 *
	 * @since   1.0.0
	 */
	public function postflight($type, $parent)
	{
		return true;
	}

	/**
	 * Check if Joomla version passes minimum requirement
	 *
	 * @return  boolean  True if meets minimum version
	 *
	 * @since   1.0.0
	 */
	private function checkJoomlaVersion()
	{
		if (version_compare(JVERSION, $this->minimumJoomla, '<'))
		{
			\Joomla\CMS\Factory::getApplication()->enqueueMessage(
				'Cluster requires Joomla ' . $this->minimumJoomla . ' or higher',
				'error'
			);

			return false;
		}

		return true;
	}

	/**
	 * Check if PHP version passes minimum requirement
	 *
	 * @return  boolean  True if meets minimum version
	 *
	 * @since   1.0.0
	 */
	private function checkPhpVersion()
	{
		if (version_compare(PHP_VERSION, $this->minimumPhp, '<'))
		{
			\Joomla\CMS\Factory::getApplication()->enqueueMessage(
				'Cluster requires PHP ' . $this->minimumPhp . ' or higher',
				'error'
			);

			return false;
		}

		return true;
	}
}
