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

class RsticketsproViewKbresults extends HtmlView
{
	public function display($tpl = null)
	{
		// set the JSON headers
		header('Content-Type: application/json; charset=utf-8');
		
		$this->items = $this->get('Items');
		
		// parse the results
		$results = array();
		foreach ($this->items as $item)
		{
			$results[] = array(
				'label' => $item->name,
				'value' => $item->id
			);
		}
		
		// display the results
		echo json_encode(array(
			'list' => $results
		));

		// end application
		Factory::getApplication()->close();
	}
}