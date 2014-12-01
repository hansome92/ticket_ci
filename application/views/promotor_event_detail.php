<div class="events container content">
	<div class="row">
		<div class="col-xs-12 ticketbox">
			<h2><?=$event['EventName']?></h2>
			<!--<ul>
				<li><a href="#">Home</a></li>
				<li><a href="#">Acts</a></li>
				<li><a href="#">Tickets</a></li>
			</ul>-->
			<!--<ul>
				<li>-->
					<!--<h3>Home</h3>-->
				<!--</li>
				<li>
					<h3>Acts</h3>
					<table style="position:relative;">
						<tbody>
							<? //foreach($events['preferences'] as $act): ?>
								<tr>
									<td><a href="<?=$base?>dashboard/event/">ja</a></td>
								</tr>
							<? //endforeach; ?>
						</tbody>
					</table>
					<div>
						<a href="<?=$base?>dashboard/newacts">Add acts...</a>
					</div>
				</li>
				<li>-->
					<h3>Tickets</h3>
					<table>
						<thead>
							<th>Naam</th>
							<th>Prijs</th>
							<th>Aantal</th>
							<th>Verkocht</th>
							<th>Totaal ingescanned</th>
						</thead>
						<tbody>
							<? foreach($event['tickets'] as $ticket):?>
								<tr>
									<td><?=$ticket['preferences'][11]['Value']?></td>
									<td>&euro;<?=$ticket['preferences'][12]['Value']?></td>
									<td><?=$ticket['preferences'][13]['Value']?></td>
									<td><?=$ticket['tickets_sold']?></td>
									<td><?=$ticket['tickets_scanned']?></td>
								</tr>
							<? endforeach; ?>
						</tbody>
					</table>
					<div>
						<a href="<?=$base?>dashboard/event/<?=$event['EventID'];?>/newtickets">Add tickets...</a>
					</div>
				<!--</li>-->
			</div>
		</div>
	</div>