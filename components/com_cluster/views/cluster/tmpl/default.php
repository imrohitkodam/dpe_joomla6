<?php
/**
 * @package    Com_Cluster
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (C) 2009 - 2018 Techjoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

?>
<div class="cluster-item">
	<div class="page-header">
		<h1><?php echo $this->escape($this->item->name); ?></h1>
	</div>

	<?php if (!empty($this->item->description)) : ?>
		<div class="item-description">
			<?php echo $this->item->description; ?>
		</div>
	<?php endif; ?>

	<div class="item-details">
		<dl class="dl-horizontal">
			<?php if (!empty($this->item->client)) : ?>
				<dt><?php echo Text::_('COM_CLUSTER_CLIENT'); ?></dt>
				<dd><?php echo $this->escape($this->item->client); ?></dd>
			<?php endif; ?>

			<?php if (!empty($this->item->client_id)) : ?>
				<dt><?php echo Text::_('COM_CLUSTER_CLIENT_ID'); ?></dt>
				<dd><?php echo $this->escape($this->item->client_id); ?></dd>
			<?php endif; ?>
		</dl>
	</div>
</div>
