

<section class="title">
	<!-- We'll use $this->method to switch between faq.create & faq.edit -->
	<h4><?php echo lang('simple_order:edit'); ?> Product</h4>
</section>

<section class="item">
	<div class="content">
		<table>
            <tbody>
                <tr>
                	<td>
                		<dt>Nama Pemesan</dt>
                		<dd><?php echo $profile->first_name.' '.$profile->last_name; ?></dd>
                		<dt>Alamat Email</dt>
                		<dd><?php echo $profile->email; ?></dd>
                    	<dt>Alamat Kirim</dt>
                    	<dd><?php echo $data->shipping_address; ?></dd>
                    </td>
                    <td>
                    	<dt>No. Telepon</dt>
                    	<dd><?php echo $data->phone; ?></dd>
                    	<dt>Sekolah</dt>
                    	<dd><?php echo $profile->sekolah; ?></dd>
                    	<dt>Provinsi</dt>
                    	<dd><?php echo $data->province; ?></dd>
                	</td>
                    <td><?php echo $form; ?></td>
                </tr>
            </tbody>
        </table>
        <?php //dump($data);?>

        <br>
    	
    	<table>
        	<thead>
	            <tr>
	            	<th colspan="4" class="title"><em>Order Items</em></th>
	            </tr>
	            <tr>
	            	<th>Product Code</th>
	                <th>Price</th>
	                <th>Qty</th>
	                <th style="text-align:right">Total</th>
	            </tr>
        	</thead>

	        <tbody>
	            <?php if(!empty($orderproduct['entries'])): 
	            	foreach($orderproduct['entries'] as $items):?>
	                <tr>
		                <td><?php echo $items['product_id']['product_code']; ?></td>
		                <td><?php echo $this->settings->currency; ?> <?php echo number_format($items['product_price'], 2, ",", "."); ?></td>
		                <td><?php echo $items['qty']; ?></td>
		                <td style="text-align:right"><?php echo $this->settings->currency; ?> <?php echo number_format($items['sub_total'], 2, ",", "."); ?></td>
		            </tr>
				<?php endforeach; endif; ?>	
					<tr>
						<td colspan="3"><strong>Total Bayar</strong></td>
	                	<td style="text-align:right"><strong><?php echo $this->settings->currency; ?> <?php echo number_format($data->order_total, 2, ",", "."); ?></strong></td>
	            	</tr>
	        </tbody>
    	</table>
        <br>
        <div class="buttons" style="clear:both; text-align: right;">
            <a href="<?php echo site_url('admin/order/delete_order/'.$data->id); ?>" class="button grey confirm">Hapus Order</a>
        </div>
    </div>
</section>

<style>
	dt {line-height: 16px; font-weight: bold;}
	dd {line-height: 16px; margin-bottom: 10px;}
</style>