<div class="content main-tab-content" id="worklogsContent" data-tab="worklogs">
			<h5 class="title is-pulled-left is-5">Worklogs</h5>
			@if($user->id == $farm->owner || auth()->user()->role == 1)
				<div class="tabs is-pulled-right is-toggle" id="worklogsTabs">
					<ul class="is-marginless">
						<li class="is-marginless {{($farm->fields->count() > 0)? '':'is-disabled'}}">
							<a class="is-success-tab " data-action="newWorklog">New Worklog</a>
						</li>
						<li class=" is-marginless is-active">
							<a data-tab="normalWorklogs">Worklogs</a>
						</li>
						<li class="is-marginless">
							<a class="is-danger-tab" data-tab="trashedWorklogs">Trashed</a>
						</li>
					</ul>
				</div>
			@endif
			<div class="is-clearfix"></div>
			<div id="normalWorklogs" class="tab-content is-active" data-tab="normalWorklogs">
				<p id="noWorklogs" class="is-fullwidth has-text-centered has-text-info has-text-weight-semibold is-unselectable {{($farm->worklogs->count() < 1)? 'showing':'is-hidden'}}">No Worklogs To Show</p>
				<p id="noFields" class="is-fullwidth has-text-centered has-text-info has-text-weight-semibold is-unselectable {{($farm->worklogs->count() < 1 && ($user->id == $farm->owner || $user->role == 1) && $farm->fields->count() < 1)? 'showing':'is-hidden'}}">The Fam Needs To Have Fields Before You Can Create A Worklog</p>
				<div class="columns is-multiline is-marginless">
					
					@foreach($farm->worklogs()->orderBy('id','desc')->get() as $worklog)
					<div class="column is-one-third worklog"  data-worklog-id="{{$worklog->id}}">

							<div class="card has-text-centered ">
								<a href="{{ url('/farm/'.$farm->id.'/worklog/'.$worklog->id) }}" class="has-text-centered">
									<header	class="card-header has-text-centered">
										<p class="card-header-title has-text-centered">{{is_null($worklog->name)? 'Season '.$worklog->season:$worklog->name.' - Season '.$worklog->season}}</p>
									</header>
								</a>
								@if($user->id == $farm->owner)
								<div class="card-footer">
									<a class="card-footer-item worklogRenameButton">Re Name</a>
									<a class="card-footer-item has-text-danger worklogTrashButton">Trash</a>
								</div>
								@endif
							</div>

					</div>
					@endforeach
				</div>
			</div>	
			
			
			@if($user->id == $farm->owner  || auth()->user()->role == 1)
			<div id="trashedWorklogs" class="tab-content" data-tab="trashedWorklogs">
				<div class="columns is-marginless is-multiline">
					@foreach($farm->worklogs()->onlyTrashed()->orderBy('id','desc')->get() as $worklog)
					<div class="column is-one-third worklog" data-worklog-id="{{$worklog->id}}">

							<div class="card has-text-centered">
								<a href="{{ url('/farm/'.$farm->id.'/worklog/'.$worklog->id) }}" class="has-text-centered">
									<header	class="card-header has-text-centered">
										<p class="card-header-title has-text-centered">{{is_null($worklog->name)? 'Season '.$worklog->season:$worklog->name.' - Season '.$worklog->season}}</p>
									</header>
								</a>
								<div class="card-footer">
									<a class="card-footer-item worklogRecoverButton">Restore</a>
									<a class="card-footer-item has-text-danger worklogDeleteButton">Delete</a>
								</div>
							</div>

					</div>
					@endforeach
				</div>
			</div>
			@endif
		</div>