<div class="container">
	<div class="row">
		<div class="col-xs-6">
			<h1>{$ref_table}</h1>
			<table style="width:inherit;">
				<tr><td>Order Date: </td><td>{$po.created_date}</td></tr>
				<tr><td>Order Number: </td><td>{$po.purchase_order_number}</td></tr>
				<tr><td>Payment Terms: </td><td>{$po.payment_terms}</td></tr>
			</table>
		</div>
		<div class="col-xs-6" style="text-align:right;">
			<img src="../{$url}assets/img/black-logo.png"/>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6">
			<h3>Billing Address</h3>
			<table style="width:inherit;">
				<tr><td>{$po.name}</td></tr>
				<tr><td>{$po.bill_address} {$po.bill_address_two|default:''}</td></tr>
				<tr><td>{$po.bill_city} {$po.bill_state} {$po.bill_zip}</td></tr>
				<tr><td>{$po.phone}</td></tr>
			</table>
		</div>
		<div class="col-xs-6">
			<h3>Shipping Address</h3>
			<table style="width:inherit;">
				<tr><td>{$po.name}</td></tr>
				<tr><td>{$po.ship_address} {$po.ship_address_two|default:''}</td></tr>
				<tr><td>{$po.ship_city} {$po.ship_state} {$po.ship_zip}</td></tr>
				<tr><td>{$po.phone}</td></tr>
			</table>
		</div>
	</div>
	<div class="row" style="margin-top:15px;">
		<div class="col-xs-12">
			<table class="table">
				<thead>
				<tr style="background-color:#efefef;">
					<th>Qty</th>
					<th>Product #</th>
					<th>Item</th>
					<th>Description</th>
					<th>Unit Price</th>
					<th>Line Total</th>
				</tr>
				</thead>
				<tbody>
					{assign var='total' value=0}
					{foreach $lineItems as $li}
						{assign var='lt' value=($li.price * $li.product_qty)}
						<tr>
							<td>{$li.product_qty}</td>
							<td>{$li.product_number}</td>
							<td>{$li.name}</td>
							<td>{$li.description}</td>
							<td>{$li.price}</td>
							<td>{$lt|number_format:2}</td>
						</tr>
						{assign var='total' value=$total+$lt}
					{/foreach}
					<tr><td colspan="5" style="text-align:right;font-weight:bold;">Total: </td><td>{$total|number_format:2}</td></tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="col-sm-12 text-right row">
	<button onclick="slide(7);" class="btn btn-info btn-form-success" ><i class="fa fa-reply"></i> Return to Invoices</button>
</div>