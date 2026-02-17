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

$canEdit		 = Factory::getUser()->authorise('kbarticle.edit', 'com_rsticketspro');
$canChange		 = Factory::getUser()->authorise('kbarticle.edit.state', 'com_rsticketspro');
$canEditCategory = Factory::getUser()->authorise('kbcategory.edit', 'com_rsticketspro');
$listOrder 	= $this->escape($this->state->get('list.ordering'));
$listDirn 	= $this->escape($this->state->get('list.direction'));
$saveOrder	= $listOrder == 'a.ordering' && $canChange;

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_rsticketspro&task=kbarticles.saveOrderAjax&tmpl=component';
	HTMLHelper::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
?>
<form action="<?php echo Route::_('index.php?option=com_rsticketspro&view=kbarticles'); ?>" method="post" name="adminForm" id="adminForm">
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
				<th style="width:1%" class="nowrap text-center"><?php echo HTMLHelper::_('searchtools.sort', '', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
				<th><?php echo HTMLHelper::_('searchtools.sort', 'RST_KB_ARTICLE_NAME', 'a.name', $listDirn, $listOrder); ?></th>
				<th><?php echo HTMLHelper::_('searchtools.sort', 'RST_KB_CATEGORY_NAME', 'c.name', $listDirn, $listOrder); ?></th>
				<th width="1%" nowrap="nowrap"><?php echo HTMLHelper::_('searchtools.sort', 'RST_KB_HITS', 'a.hits', $listDirn, $listOrder); ?></th>
				<th width="1%" nowrap="nowrap"><?php echo HTMLHelper::_('searchtools.sort', 'RST_PRIVATE', 'a.private', $listDirn, $listOrder); ?></th>
				<th width="1%" nowrap="nowrap"><?php echo HTMLHelper::_('searchtools.sort', 'JPUBLISHED', 'a.published', $listDirn, $listOrder); ?></th>
				<th width="1%"><?php echo HTMLHelper::_('searchtools.sort', 'ID', 'a.id', $listDirn, $listOrder); ?></th>
			</tr>
			</thead>
			<tbody <?php if ($saveOrder) { ?> class="js-draggable" data-url="<?php echo $saveOrderingUrl; ?>" data-direction="<?php echo strtolower($listDirn); ?>" data-nested="false"<?php } ?>>
			<?php
			foreach ($this->items as $i => $item)
			{
				?>
				<tr data-draggable-group="<?php echo $item->category_id; ?>">
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
							echo HTMLHelper::_('link', Route::_('index.php?option=com_rsticketspro&task=kbarticle.edit&id='.(int) $item->id), $this->escape($item->name));
						}
						else
						{
							echo $this->escape($item->name);
						}
						?>
					</td>
					<td>
						<?php
						if ($item->category_id)
						{
							if ($canEditCategory)
							{
								echo HTMLHelper::_('link', Route::_('index.php?option=com_rsticketspro&task=kbcategory.edit&id='.(int) $item->category_id), $this->escape($item->category_name));
							}
							else
							{
								echo $this->escape($item->category_name);
							}
						}
						else
						{
							echo Text::_('RST_KB_NO_PARENT');
						}
						?>
					</td>
					<td width="1%" nowrap="nowrap"><?php echo $this->escape($item->hits); ?></td>
					<td width="1%" nowrap="nowrap" align="center">
						<?php
						echo HTMLHelper::_('jgrid.state', array(
							0 => array('setprivate', 'JYES', '', '', false, 'unpublish', 'unpublish'),
							1 => array('unsetprivate', 'JNO', '', '', false, 'publish', 'publish')
						), $item->private, $i, 'kbarticles.', false);
						?>
					</td>
					<td width="1%" nowrap="nowrap" align="center"><?php echo HTMLHelper::_('jgrid.published', $item->published, $i, 'kbarticles.', $canChange); ?></td>
					<td width="1%"><?php echo $this->escape($item->id); ?></td>
				</tr>
				<?php
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