

<section class="title">
	<!-- We'll use $this->method to switch between faq.create & faq.edit -->
	<h4><?php echo lang('simple_order:edit'); ?> Product</h4>
</section>

<section class="item">
	<div class="content">
		<table>
        	<thead>
            	<tr class="title">
	            	<th width="150px">Username</th>
	                <th width="150px">Alamat Kirim</th>
	                <th width="150px">Email</th>
	                <th>Status</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                	<td><?php echo $data->created_by_username; ?></td>
                    <td><?php echo $data->alamat_kirim; ?></td> 
                    <td><?php echo $data->created_by_email; ?></td>
                    <td><?php echo $form; ?></td>
                </tr>
            </tbody>
        </table>
        <!-- <?php //dump($orderproduct);?> -->

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
		                <td><?php echo $items['produk_id']['product_code']; ?></td>
		                <td><?php echo $this->settings->currency; ?> <?php echo number_format($items['harga'], 2, ",", "."); ?></td>
		                <td><?php echo $items['qty']; ?></td>
		                <td style="text-align:right"><?php echo $this->settings->currency; ?> <?php echo number_format($items['sub_total'], 2, ",", "."); ?></td>
		            </tr>
				<?php endforeach; endif; ?>	
					<tr>
						<td colspan="3"><strong>Total Bayar</strong></td>
	                	<td style="text-align:right"><strong><?php echo $this->settings->currency; ?> <?php echo number_format($data->harga, 2, ",", "."); ?></strong></td>
	            	</tr>
	        </tbody>
    	</table>
    </div>
</section>