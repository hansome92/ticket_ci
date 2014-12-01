<div id="content" class="dashboard">
	<script type="text/javascript">
		$( document ).ready(function() {
			$("#barchart").barChart(data);
		});
	</script>
	<div class="row" id="top-row">
		<div class="col-lg-6 col-sm-12 blocks" id="tickets-sold">
			<h2>Ticket Sales</h2>
			<!--<div class="top-select select">
				<select class="basic">
					<option>90 days</option>
					<option>30 days</option>
					<option selected>7 days</option>
				</select>
			</div>-->
			<div class="clear"></div>
			<!--<a class="scroll-next">Next</a>
			<a class="scroll-prev">Prev</a>-->
			<div class="clear" style="height:20px;"></div>
			
			<div id="barchart" class="row">
				<div id="y-axis" class="col-xs-2">

				</div>
				<div class="col-xs-10" id="bars-container">
					<div id="bars"></div>
				</div>
				<div class="col-xs-10 col-xs-offset-2" id="x-axis"></div>
			</div>
		</div>
		<div class="col-lg-6 col-sm-12 blocks" id="events-overview">
			<h2>Events</h2>
			<!--<div id="events-overview-slider-controls">
				<a href="javascript:;" class="events-overview-slide-next"></a>
				<a href="javascript:;" class="events-overview-slide-prev"></a>
			</div>-->
			<div id="event-overview" style="float: left; width: 100%;">
				<? foreach($events as $key => $event): ?>
					<div class="bar-horizontal" data-tickets-checked-in="<?=$event['tickets_scanned']?>" data-tickets-sold="<?=$event['tickets_sold']?>" data-tickets-max="<?=$event['total_available_tickets']?>" data-event-title="<?=$event['EventName']?>" data-event-id="<?=$event['EventID']?>"></div>
				<? endforeach; ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6 col-sm-12 blocks" id="">
			<h2>Statistics(last week)</h2>
			<!--<div class="top-select select">
				<select class="basic">
					<option>90 days</option>
					<option>30 days</option>
					<option>7 days</option>
				</select>
			</div>-->
			<table class="datatable">
				<thead>
					<tr>
						<th>Type</th>
						<th>Info</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Tickets</td>
						<td><span><?=$statistics['totalsoldperweek']?></span> Sold</td>
					</tr>
					<tr>
						<td>Promotion</td>
						<td><span>144.342</span> Emails gathered</td>
					</tr>
					<tr>
						<td>Social Media Shares</td>
						<td><span>101.000</span> Shares</td>
					</tr>
					<tr>
						<td>Gender</td>
						<td><span>62,3%</span> Male <span>37,7%</span> Female</td>
					</tr>
					<tr>
						<td>Average age</td>
						<td><span>25</span> Years old</td>
					</tr>
					<tr>
						<td>Top country</td>
						<td>The Netherlands</td>
					</tr>
					<tr>
						<td>Top city</td>
						<td>The Hague</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

</div>