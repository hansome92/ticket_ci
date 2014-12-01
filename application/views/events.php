<div class="container content" id="ordertickets">
	<div class="row">
		<div class="col-xs-12 ticketbox">
			<div class="events">
				<h2>Events</h2>
				<table style="float:left; position: relative; display:block; margin: 10px;">
					<tbody>
						<? foreach($events as $event): if( !empty($event['tickets']) && strtotime(str_replace('/', '-', $event['preferences']['start_date']['Value'])) > time() && $event['Status'] != '2'):?>
							<tr>
								<td><!--<a href="<?=$base?>event/<?=$event['MetaLink']?>">--><?=$event['EventName'];?><!--</a>--></td>
								<td><a href="<?=$base?>order/<?=$event['MetaLink']?>">Buy Tickets</a></td>
							</tr> 
						<? endif; endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>