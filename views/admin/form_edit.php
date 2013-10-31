

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
                		<dd><?php echo $data->created_by_email; ?></dd>
                    	<dt>Alamat Kirim</dt>
                    	<dd><?php echo $data->alamat_kirim; ?></dd>
                    </td>
                    <td>
                    	<dt>Sekolah</dt>
                    	<dd><?php echo $profile->sekolah; ?></dd>
                    	<dt>Alamat Sekolah</dt>
                    	<dd><?php echo $profile->alamat_sekolah; ?></dd>
                    	<dt>Provinsi</dt>
                    	<dd><?php echo $profile->provinsi; ?></dd>
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
    </div>
</section>

<style>
	dt {line-height: 16px; font-weight: bold;}
	dd {line-height: 16px; margin-bottom: 10px;}
</style>