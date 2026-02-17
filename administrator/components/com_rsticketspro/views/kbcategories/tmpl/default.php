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

use Joomla\CMS\HTML\HTMLHelper;

use Joomla\CMS\Language\Text;

use Joomla\CMS\Factory;

$canEdit	= Factory::getUser()->authorise('kbcategory.edit', 'com_rsticketspro');
$canChange	= Factory::getUser()->authorise('kbcategory.edit.state', 'com_rsticketspro');
$listOrder 	= $this->escape($this->state->get('list.ordering'));
$listDirn 	= $this->escape($this->state->get('list.direction'));
$saveOrder	= $listOrder == 'ordering' && $canChange;

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_rsticketspro&task=kbcategories.saveOrderAjax&tmpl=component';
	HTMLHelper::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
?>
<form action="<?php echo Route::_('index.php?option=com_rsticketspro&view=kbcategories'); ?>" method="post" name="adminForm" id="adminForm">
	<?php
	echo RsticketsproAdapterGrid::sidebar();

	echo \Joomla\CMS\Layout\LayoutHelper::render('joomla.searchtools.default', array('view' => $this));

	if (empty($this->items))
	{
	?>
	<div class="alert alert-info">
		<span class="fa fa-info-circle" aria-hidden="true"></span><span class="sr-only"><?php echo Text::_('INFO'); ?></span>
		<?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
	</div>
	<?php
	}
	else
	{
		?>
		<table class="table table-striped" id="articleList">
			<thead>
			<tr>
				<th width="1%" nowrap="nowrap"><?php echo HTMLHelper::_('grid.checkall'); ?></th>
				<th style="width:1%" class="nowrap text-center"><?php echo HTMLHelper::_('searchtools.sort', '', 'ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
				<th><?php echo HTMLHelper::_('searchtools.sort', 'RST_KB_CATEGORY_NAME', 'name', $listDirn, $listOrder); ?></th>
				<th width="1%" nowrap="nowrap"><?php echo HTMLHelper::_('searchtools.sort', 'RST_PRIVATE', 'private', $listDirn, $listOrder); ?></th>
				<th width="1%" nowrap="nowrap"><?php echo HTMLHelper::_('searchtools.sort', 'JPUBLISHED', 'published', $listDirn, $listOrder); ?></th>
				<th width="1%"><?php echo HTMLHelper::_('searchtools.sort', 'ID', 'id', $listDirn, $listOrder); ?></th>
			</tr>
			</thead>
			<tbody <?php if ($saveOrder) { ?> class="js-draggable" data-url="<?php echo $saveOrderingUrl; ?>" data-direction="<?php echo strtolower($listDirn); ?>" data-nested="false"<?php } ?>>
			<?php
			$i = 0;
			foreach ($this->items as $item)
			{
				?>
				<tr data-draggable-group="<?php echo $item->parent_id; ?>">
					<td width="1%" nowrap="nowrap"><?php echo HTMLHelper::_('grid.id', $i, $item->id); ?></td>
					<td class="order text-center">
						<?php
						$disableClassName = '';
						$disabledLabel	  = '';

						if (!$saveOrder)
						{
							$disabledLabel    = Text::_('JORDERINGDISABLED');
							$disableClassName = 'inactive';
						}
						?>
						<span class="sortable-handler <?php echo $disableClassName; ?>" title="<?php echo $disabledLabel; ?>">
							<i class="icon-menu"></i>
						</span>
						<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order" />
					</td>
					<td>
						<?php
						if ($canEdit)
						{
							echo HTMLHelper::_('link', Route::_('index.php?option=com_rsticketspro&task=kbcategory.edit&id='.(int) $item->id), (isset($item->treename) ? $item->treename : '') . $this->escape($item->name));
						}
						else
						{
							echo (isset($item->treename) ? $item->treename : '') . $this->escape($item->name);
						}
						?>
					</td>
					<td width="1%" nowrap="nowrap" align="center">
						<?php
						echo HTMLHelper::_('jgrid.state', array(
							0 => array('setprivate', 'JYES', '', '', false, 'unpublish', 'unpublish'),
							1 => array('unsetprivate', 'JNO', '', '', false, 'publish', 'publish')
						), $item->private, $i, 'kbcategories.', false);
						?>
					</td>
					<td width="1%" nowrap="nowrap" align="center"><?php echo HTMLHelper::_('jgrid.published', $item->published, $i, 'kbcategories.', $canChange); ?></td>
					<td width="1%"><?php echo $this->escape($item->id); ?></td>
				</tr>
				<?php
				$i++;
			}
			?>
			</tbody>
		</table>
		<?php
		echo $this->pagination->getListFooter();
	}
	?>
	
	<div>
		<?php echo HTMLHelper::_( 'form.token' ); ?>
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="task" value="" />
	</div>
	</div>
</form>