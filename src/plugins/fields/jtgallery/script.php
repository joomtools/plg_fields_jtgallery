<?php
/**
 * @package      Joomla.Plugin
 * @subpackage   Fields.Jtgallery
 *
 * @author       Barbara Assmann, Guido De Gobbis
 * @copyright    (c) JoomTools.de - All rights reserved.
 * @license      GNU General Public License version 3 or later
 */

defined('_JEXEC') or die;

/**
 * Foo script file.
 *
 * @package     A package name
 *
 * @since       1.0.0
 */
class plgFieldsJtgalleryInstallerScript
{
	/**
	 * Extension script constructor.
	 *
	 * @since   1.0.0
	 */
	public function __construct()
	{
		// Define the minumum versions to be supported.
		$this->minimumJoomla = '3.9';
		$this->minimumPhp    = '7.0';
	}

	/**
	 * Function to act prior to installation process begins
	 *
	 * @param   string      $action     Which action is happening
	 *                                  (install|uninstall|discover_install|update)
	 * @param   JInstaller  $installer  The class calling this method
	 *
	 * @return   bool        True on success
	 * @throws   \Exception  Error if Joomla and PHP versions are lower then minimum
	 *
	 * @since    1.0.0
	 */
	public function preflight($action, $installer)
	{
		$app = JFactory::getApplication();
		JFactory::getLanguage()->load('plg_fields_jtgallery', dirname(__FILE__));

		if (version_compare(PHP_VERSION, $this->minimumPhp, 'lt'))
		{
			$app->enqueueMessage(JText::_('JTGALLERY_MINPHPVERSION'), 'error');

			return false;
		}

		if (version_compare(JVERSION, $this->minimumJoomla, 'lt'))
		{
			$app->enqueueMessage(JText::_('JTGALLERY_MINJVERSION'), 'error');

			return false;
		}

		return true;
	}

	/**
	 * Called after any type of action
	 *
	 * @param   string      $action     Which action is happening
	 *                                  (install|uninstall|discover_install|update)
	 * @param   JInstaller  $installer  The class calling this method
	 *
	 * @return   bool  True on success
	 *
	 * @since    1.0.0
	 */
	public function postflight($action, $installer)
	{
		return true;
	}

	/**
	 * Method to update Joomla!
	 *
	 * @param   JInstaller  $installer  The class calling this method
	 *
	 * @return   void
	 *
	 * @since    1.0.0
	 */
	public function update($installer)
	{
		$this->deleteUnexistingFiles();
	}

	/**
	 * Delete files that should not exist
	 *
	 * @return   void
	 *
	 * @since    1.0.0
	 */
	public function deleteUnexistingFiles()
	{
		$files = array(
			'/plugins/fields/jtgallery/tmpl/layouts/default.php'
		);

		jimport('joomla.filesystem.file');

		foreach ($files as $file)
		{
			if (JFile::exists(JPATH_ROOT . $file) && !JFile::delete(JPATH_ROOT . $file))
			{
				echo JText::sprintf('FILES_JOOMLA_ERROR_FILE_FOLDER', $file) . '<br />';
			}
		}
	}
}
