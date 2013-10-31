	<?php if (!empty($entries)): ?>
		<table border="0" class="table-list" cellspacing="0">
			<thead>
				<tr>
					<th>No</th>
					<th><?php echo lang('simple_order:name'); ?></th>
					<th><?php echo lang('simple_order:status'); ?></th>
					<th><?php echo lang('simple_order:alamat'); ?></th>
					<th><?php echo lang('simple_order:total'); ?></th>
					<th></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="6">
						<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php if(!empty($entries["entries"])): $i=1; foreach( $entries["entries"] as $item ): ?>
				<tr id="item_<?php echo $item["id"]; ?>">
					<td><?php echo $i; ?></td>
					<td><?php echo $item["created_by"]["display_name"]; ?></td>
					<td><?php echo $item["status"]["value"]; ?></td>
					<td><?php echo $item["alamat_kirim"]; ?></td>
					<td><?php echo $this->settings->currency; ?> <?php echo number_format($item["harga"], 2, ",", "."); ?></td>
					<td class="actions">
						<?php echo anchor('admin/order/edit/'.$item["id"], lang('simple_order:edit'), array('class'=>'button', 'title'=>lang('simple_order:edit'))); ?>
					</td>
				</tr>
				<?php $i++; endforeach; else: ?> <div class="no_data"><?php echo lang('simple_order:no_items'); ?></div> <?php  endif; ?>
			</tbody>
		</table>
	<?php else: ?>
		<div class="no_data"><?php echo lang('simple_order:no_items'); ?></div>
	<?php endif;?>