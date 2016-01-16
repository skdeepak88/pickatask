<?php $this->layout($gs_template, $ga_templatedata) ?>

<div class="container">
	<ul class="breadcrumb">
	   <li class="active">Home</li>
	</ul>

	<div class="row">
		<div class="col-sm-12 col-md-12">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#active" data-toggle="tab">Active Tasks &nbsp;<span class="badge"><?= count($la_active) ?></span></a></li>
				<li class=""><a href="#pending" data-toggle="tab">Pending Approval &nbsp;<span class="badge"><?= count($la_pending) ?></span></a></li>
				<li class=""><a href="#history" data-toggle="tab">History &nbsp;<span class="badge"><?= count($la_history) ?></span></a></li>
			</ul>
			<div id="tasktabcontent" class="tab-content">
				<div class="tab-pane fade active in" id="active">
					<? if(!empty($la_active)): ?>
						<table class="table table-striped">
							<thead>
								<tr>
								   <th>#</th>
								   <th class="text-center">Type</th>
								   <th>Created</th>
								   <th>Title</th>
								   <th>Budget</th>
								   <th>Spent</th>
								   <th>Status</th>
								   <th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<? foreach($la_active as $lo_task): ?>
								<tr>
									<td><?= $lo_task->taskid ?></td>
									<td class="text-center"><i class="fa fa-facebook-square">&nbsp;</i></td>
									<td><?= date('d/m/Y', strtotime($lo_task->created)) ?></td>
									<td><?= $lo_task->title ?></td>
									<td>$<?= number_format($lo_task->budget, 2) ?></td>
									<td>$<?= number_format($lo_task->taskpay, 2) ?></td>
									<td><span class="label label-primary"><?= ucfirst(strtolower($lo_task->status)) ?></span></td>
									<td class="text-right">
										<div class="btn-group">
											<button type="button" class="btn btn-xs btn-success">Action</button>
											<button type="button" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
											<ul class="dropdown-menu pull-right">
												<li><a href="/taskbids/<?= $lo_task->taskid ?>">Bids</a></li>
												<li><a href="#">Posts</a></li>
												<li class="divider"></li>
												<li><a href="#">Reports</a></li>
											</ul>
										</div>
									</td>
								</tr>
								<? endforeach; ?>
							</tbody>
						</table>
					<? else: ?>
						<p> No tasks </p>
					<? endif; ?>
				</div>
				<div class="tab-pane fade" id="pending">
					<? if(!empty($la_pending)): ?>
					  	<table class="table table-striped">
							<thead>
								<tr>
								   <th>#</th>
								   <th class="text-center">Type</th>
								   <th>Created</th>
								   <th>Title</th>
								   <th>Budget</th>
								   <th>Spent</th>
								   <th>Status</th>
								   <th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<? foreach($la_pending as $lo_task): ?>
								<tr>
									<td><?= $lo_task->taskid ?></td>
									<td class="text-center"><i class="fa fa-facebook-square">&nbsp;</i></td>
									<td><?= date('d/m/Y', strtotime($lo_task->created)) ?></td>
									<td><?= $lo_task->title ?></td>
									<td>$<?= number_format($lo_task->budget, 2) ?></td>
									<td>$<?= number_format($lo_task->taskpay, 2) ?></td>
									<td><span class="label label-primary"><?= ucfirst(strtolower($lo_task->status)) ?></span></td>
									<td class="text-right">
										<div class="btn-group">
											<button type="button" class="btn btn-xs btn-success">Action</button>
											<button type="button" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
											<ul class="dropdown-menu pull-right">
												<li><a href="<?= $lo_task->taskurl ?>">Edit</a></li>
												<li><a href="#">Delete</a></li>
												<li class="divider"></li>
												<li><a href="#">Reports</a></li>
											</ul>
										</div>
									</td>
								</tr>
								<? endforeach; ?>
							</tbody>
						</table>
					<? else: ?>
						<p> No tasks </p>
					<? endif; ?>
				</div>
				<div class="tab-pane fade" id="history">
					<? if(!empty($la_history)): ?>
						<table class="table table-striped">
							<thead>
								<tr>
								   <th>#</th>
								   <th class="text-center">Type</th>
								   <th>Created</th>
								   <th>Title</th>
								   <th>Budget</th>
								   <th>Spent</th>
								   <th>Status</th>
								   <th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<? foreach($la_history as $lo_task): ?>
								<tr>
									<td><?= $lo_task->taskid ?></td>
									<td class="text-center"><i class="fa fa-facebook-square">&nbsp;</i></td>
									<td><?= date('d/m/Y', strtotime($lo_task->created)) ?></td>
									<td><?= $lo_task->title ?></td>
									<td>$<?= number_format($lo_task->budget, 2) ?></td>
									<td>$<?= number_format($lo_task->taskpay, 2) ?></td>
									<td><span class="label label-primary"><?= ucfirst(strtolower($lo_task->status)) ?></span></td>
									<td class="text-right">
										<div class="btn-group">
											<button type="button" class="btn btn-xs btn-success">Action</button>
											<button type="button" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
											<ul class="dropdown-menu pull-right">
												<li><a href="#">Clone</a></li>
											</ul>
										</div>
									</td>
								</tr>
								<? endforeach; ?>
							</tbody>
						</table>
					<? else: ?>
						<p> No tasks </p>
					<? endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>