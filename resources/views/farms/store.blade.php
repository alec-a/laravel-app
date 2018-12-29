<a class="column is-one-third" href="{{url('farm/'.$farm->id)}}">
	<div class="box is-fullheight has-text-centered">
		<img src="{{asset('/img/barn.png')}}"></img>
		<hr/>
		<h3 class="title is-4 ">{{$farm->name}}</h3>
		<hr/>
		<p class="subtitle ">{{$farm->farmOwner->name}}</p>
	</div>
</a>