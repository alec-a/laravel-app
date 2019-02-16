<div class="content main-tab-content" id="fieldsContent" data-tab="fields">
			<h5 class="title is-5 is-pulled-left">Fields</h5>
			@if($user->id == $farm->owner || $user->role == 1)
				<div class="tabs is-toggle is-pulled-right" id="fieldsTabs">
					<ul class="is-marginless">
						<li class="is-active">
							<a data-tab="normalFields">Owned</a>
						</li>
						<li class="is-marginless">
							<a class="is-danger-tab" data-tab="trashedFields">Trashed</a>
						</li>
					</ul>
				</div>
			@endif
			<div class="is-clearfix"></div>
			<div id="normFields" class="is-active tab-content" data-tab="normalFields">	
				<div class="columns is-multiline" style="margin-top: 0px;">
					<div class="column {{($user->id == $farm->owner || $user->role == 1)? 'is-half':'is-full'}}" id="fields" data-selectable="{{($user->id == $farm->owner || $user->role == 1)? '1':'0'}}">
						{!!($user->id == $farm->owner || $user->role == 1)? '<div class="is-divider is-half-margin" data-content="Fields"></div>':''!!}
						<div class="columns is-multiline is-marginless" style="margin-top: 0px;">
							@foreach($farm->fields as $field)
							<div class="column is-one-fifth farmField {{($user->id == $farm->owner || auth()->user()->role == 1)? '':'is-unselectable'}}" data-name="{{$field->name}}" data-field-id="{{$field->id}}"><p class="has-text-weight-bold is-marginless">{{$field->name}}</p> <span class="is-size-7">{{$field->crop->name}}</span></div>
							@endforeach
						</div>

					</div>
					@if($user->id == $farm->owner || auth()->user()->role == 1)
					<div class="column is-half" id="options">
						<div class="is-divider is-half-margin" data-content="Options"></div>
						<div id="newField" class="content opened">
							<div class="field has-addons">
								<div class="control is-expanded">
									<input type="text" id="fieldName" class="input"/>
								</div>

									<div class="control">
										<button id="fieldNameButton" type="submit" class="button is-primary" data-type="new">New Field</button>
									</div>
							</div>
							<div class="buttons" id="moveToTrashOption" style="display: none;">
								<button id="moveToTrashButton" class="button is-danger is-fullwidth is-outlined">Move To Trash</button>
							</div>
						</div>
						<div id="selectedOptions" class="content">
							<div class="buttons">
								<button id="moveToTrashButton" class="button is-danger is-fullwidth is-large is-outlined">Move To Trash</button>
							</div>
						</div>
					</div>
					@endif
				</div>
			</div>
			@if($user->id == $farm->owner  || auth()->user()->role == 1)
			<div id="deletedFields" class="tab-content" data-tab="trashedFields">
				<div class="columns is-multiline" style="margin-top: 0px;">
					<div class="column {{($user->id == $farm->owner || $user->role == 1)? 'is-half':'is-full'}}" id="fields" data-selectable="1">
						{!!($user->id == $farm->owner || $user->role == 1)? '<div class="is-divider is-half-margin" data-content="Fields"></div>':''!!}
						<div class="columns is-multiline is-marginless" style="margin-top: 0px;">

							@foreach($farm->fields()->onlyTrashed()->get() as $field)
							<div class="column is-one-fifth farmField {{($user->id == $farm->owner || auth()->user()->role == 1)? '':'is-unselectable'}}" data-field-id="{{$field->id}}"><p class="has-text-weight-bold is-marginless">{{$field->name}}</p> <p class="is-size-7"><span class="icon"><i class="fas fa-trash-alt"></i></span><span> {{$field->deleted_at->format('H:i')}}<br/>{{$field->deleted_at->format('d-m-Y')}}</span></p></div>
							@endforeach
						</div>

					</div>

					<div class="column is-half" id="options">
						<div class="is-divider is-half-margin" data-content="Options"></div>
						<div id="emptyTrash" class="content opened">
							<div class="buttons">
								<button id="emptyTrashButton" class="button is-danger is-fullwidth is-large is-outlined">Empty Trash</button>
							</div>
						</div>
						<div id="selectedOptions" class="content">
							<div class="buttons">
								<button id="recoverButton" class="button is-primary is-fullwidth is-outlined">Recover Field</button>
								<button id="deleteButton" class="button is-danger is-fullwidth is-outlined">Delete Field</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endif
		</div>