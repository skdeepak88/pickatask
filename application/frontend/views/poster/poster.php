<?php $this->layout($gs_template, $ga_templatedata) ?>

<div class="container">
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#active" data-toggle="tab">Active Tasks &nbsp;<span class="badge"><?= count($la_tasks) ?></span></a></li>
				<li class=""><a href="#pending" data-toggle="tab">Pending Approval &nbsp;<span class="badge"><?= count($la_tasks) ?></span></a></li>
				<li class=""><a href="#history" data-toggle="tab">History &nbsp;<span class="badge"><?= count($la_tasks) ?></span></a></li>
				<li class="dropdown pull-right">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						Dropdown <span class="caret"></span>
					</a>
				</li>
			</ul>
			<div id="tasktabcontent" class="tab-content">
				<div class="tab-pane fade active in" id="active">
					<? if(!empty($la_active)): ?>

						<? foreach($la_active as $lo_task): ?>
							<div class="panel panel-default">
								<div class="panel-body">
									<h3 class="list-group-item-heading">
										<span class="text-left"><i class="fa fa-tasks"></i> <?= $lo_task->title ?></span>
										<small class="label label-default pull-right"><?= $lo_task->accountdetail->description ?></small>
									</h3>
									<p class="lead text-left">$<?= number_format($lo_task->taskpay,2) ?></p>
									<p class="list-group-item-text"><?= $lo_task->description ?></p>
									<p>&nbsp;</p>
									<p>
										<a class="btn btn-labeled btn-primary" href="<?= $go_system->getpostertaskurl($lo_task) ?>">
											<span class="btn-label"><i class="fa fa-eye"></i></span>View Details
										</a>
									</p>
								</div>
							</div>
						<? endforeach; ?>

					<? else: ?>
						<p> No tasks </p>
					<? endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>