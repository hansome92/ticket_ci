<div class="container content" id="ordertickets">
	<div class="row">
		<div class="cols-xs-12">
			<a class="yellowbtn" href="<?=$base?><?=$module?>/newevent">New event...</a>
		</div>

	</div>
	<div class="row">
		<div class="col-xs-6 ">
			
			<h2>Ticket sales</h2>
			<div class="canvasWrapper">

				<canvas id="total" width="449" height="300"></canvas>		
				<script>

				var barChartData = {
					labels : ["January","February","March","April","May","June","July"],
					datasets : [
					{
						fillColor : "#28B78D",
						strokeColor : "#FAFAFA",
						data : [900,590,420,320,270,220,150]
					}
					]

				}

				var myLine = new Chart(document.getElementById("total").getContext("2d")).Bar(barChartData);
				</script>
			</div>
		</div>
		<div class="col-xs-6">
			<h2>Events</h2>
			<table>
				<thead>
					<tr>
						<th>Eventname</th>
						<th></th>
						<th>Sold</th>
						<th>Scanned</th>
					</tr>
				</thead>
				<tbody>
					<? foreach($events as $event): ?>
					<tr>
						<td><a href="<?=$base?><?=$module?>/event/<?=$event['EventID']?>"><?=$event['EventName'];?></a></td>
						<td></td>
						<td><?=$event['tickets_sold']?></td>
						<td><?=$event['tickets_scanned']?></td>
					</tr>
					<tr>
						<td colspan="4" style="height: 40px;">
							<div class="scanned" style="float:left; background-color: #F7B423; height:100%; width:25%; display:block;"></div>
							<div class="sold" style="float:left; background-color: #28B78D; height:100%; width:25%; display:block;"></div>
							<div class="pending" style="float:left; background-color: #BE3231; height:100%; width:25%; display:block;"></div>
							<div class="rest" style="float:left; background-color: #8A949B; height:100%; width:25%; display:block;"></div>
						</td>
					</tr>
				<? endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
</div>