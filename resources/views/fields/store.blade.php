<div class="columns farmField" id="field_{{$field->id}}">
	<div class="column is-one-fifth options">
		<div class="hidden">
			 <div class="field is-grouped">
				<div class="control">
					<button name="fieldId" value="{{$field->id}}" class="button is-danger deleteField"><span class="icon is-small"><i class="fas fa-trash-alt"></i></span></button>
				</div>
				<div class="control">
					<button name="fieldId" value="{{$field->id}}" class="button is-link editField"><span class="icon is-small"><i class="fas fa-pencil-alt"></i></span></button>
				</div>
			 </div>
		</div>
	</div>
	<div class="column is-two-fifths fieldName">{{$field->name}}</div>
	<div class="column is-two-fifths fieldCrop">{{$field->crop->name}}</div>

</div>