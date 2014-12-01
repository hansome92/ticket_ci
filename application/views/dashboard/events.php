<div id="content" class="dashboard">
	<div class="row" id="">
		<div class="col-lg-12 col-sm-12 full-block-datatable" id="">
			<h2>Events</h2>
			<table class="datatable">
				<thead>
					<tr>
						<th>Event</th>
						<th>Status</th>
						<th></th>
						<th>Actions</th>
						<th>Ticket metalink</th>
					</tr>
				</thead>
				<tbody>
					<? foreach($events as $event):?>
						<tr>
							<td><?=$event['EventName']?></td>
							<td><?=(isset($event['current_status']['url']) ? '<a href="'.$event['current_status']['url'].'">'.$event['current_status']['message'].'</a>' : $event['current_status']['message']) ?></td>
							<td></td>
							<td><a href="<?=$base?>dashboard/newevent/<?=$event['EventID']?>">Edit</a> <a href="<?=$base?>dashboard/deleteevent/<?=$event['EventID']?>" class="confirm-delete">Delete</a></td>
							<td><a href="<?=$base?>order/<?=$event['MetaLink']?>"><?=$base?>order/<?=$event['MetaLink']?></a></td>
						</tr>
					<? endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>

</div>