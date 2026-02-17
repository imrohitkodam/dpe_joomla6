<?php
/**
 * @package    RSTickets! Pro
 *
 * @copyright  (c) 2010 - 2016 RSJoomla!
 * @link       https://www.rsjoomla.com
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl-3.0.en.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;

use Joomla\CMS\Language\Text;

class RSFilterBar
{
	// load the formbehavior
	public $behavior = true;
	// show the search (filter)
	public $search = null;
	// show the pagination limit box
	public $limitBox = null;
	// show additional items located in the right
	public $rightItems = array();
	// show additional items located in the left
	public $leftItems = array();
	// show the ordering select
	public $orderDir = true;
	public $listDirn = '';
	// show the sorting select
	public $sortFields = array();
	public $listOrder = '';

	public function __construct($options=array()) {
		foreach ($options as $k => $v) {
			$this->{$k} = $v;
		}

		if ($this->behavior) {
			HTMLHelper::_('formbehavior.chosen', 'select');
		}
	}

	protected function escape($string) {
		return htmlentities($string, ENT_COMPAT, 'utf-8');
	}

	public function show() {
		if ($this->sortFields || $this->orderDir) {
			HTMLHelper::_('formbehavior.framework', true);
			HTMLHelper::script('com_rsticketspro/ordertable.js', array('relative' => true));
		}
		?>
		<div id="filter-bar" class="btn-toolbar">
			<?php if ($this->search) { ?>
				<div class="filter-search btn-group pull-left">
					<label for="filter_search" class="element-invisible"><?php echo $this->search['label']; ?></label>
					<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo $this->escape($this->search['label']); ?>" value="<?php echo $this->escape($this->search['value']); ?>" title="<?php echo $this->escape($this->search['label']); ?>" />
				</div>
				<div class="btn-group hidden-phone pull-left">
					<button class="btn" type="submit" title="<?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
					<button class="btn" type="button" onclick="document.getElementById('filter_search').value='';this.form.submit();" title="<?php echo Text::_('JSEARCH_FILTER_CLEAR'); ?>"><i class="icon-remove"></i></button>
				</div>
			<?php } ?>
			<?php if ($this->leftItems) { ?>
				<div class="btn-group pull-left">
					<?php foreach ($this->leftItems as $item) { ?>
						<?php echo $item; ?>
					<?php } ?>
				</div>
			<?php } ?>
			<?php if ($this->limitBox) { ?>
				<div class="btn-group pull-right hidden-phone">
					<label for="limit" class="element-invisible"><?php echo Text::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
					<?php echo $this->limitBox; ?>
				</div>
			<?php } ?>
			<?php if ($this->orderDir) { ?>
				<div class="btn-group pull-right hidden-phone">
					<label for="directionTable" class="element-invisible"><?php echo Text::_('JFIELD_ORDERING_DESC');?></label>
					<select name="filter_order_Dir" id="directionTable" class="input-small" onchange="Joomla.orderTable('<?php echo $this->escape($this->listOrder); ?>')">
						<?php echo HTMLHelper::_('select.options', array(HTMLHelper::_('select.option', '', Text::_('JFIELD_ORDERING_DESC')), HTMLHelper::_('select.option', 'asc', Text::_('JGLOBAL_ORDER_ASCENDING')), HTMLHelper::_('select.option', 'desc', Text::_('JGLOBAL_ORDER_DESCENDING'))), 'value', 'text', $this->listDirn, false); ?>
					</select>
				</div>
			<?php } ?>
			<?php if ($this->sortFields) { ?>
				<div class="btn-group pull-right">
					<label for="sortTable" class="element-invisible"><?php echo Text::_('JGLOBAL_SORT_BY');?></label>
					<select name="filter_order" id="sortTable" class="input-medium" onchange="Joomla.orderTable('<?php echo $this->escape($this->listOrder); ?>')">
						<option value=""><?php echo Text::_('JGLOBAL_SORT_BY');?></option>
						<?php echo HTMLHelper::_('select.options', $this->sortFields, 'value', 'text', $this->listOrder);?>
					</select>
				</div>
			<?php } ?>

			<div class="clearfix"> </div>
		</div>
		<?php
	}
}