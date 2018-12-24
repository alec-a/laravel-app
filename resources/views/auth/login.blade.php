@extends('layouts.site')

@section('content')
<div class='columns is-overlay'>
	<div class="column is-block" style="flex-grow: 0;width:400px; margin: 0 auto; flex-basis:400px;">
		<div class='card'>
			<header class='card-header'>
				<p class='card-header-title has-text-centered is-inline'>Login</p>
			</header>
			<div class="card-content">
				<div class="content">
					<form method="post" action="{{ route('login') }}">
						@csrf
						<div class='field is-narrow'>
							<label for="email" class="label {{$errors->has('email')?'has-text-danger':''}}">{{__("Email")}}</label>
							@if($errors->has('email'))
								<ul class='has-text-danger is-size-7' style='list-style:none;'>
									@foreach($errors->get('email') as $message)
										<li><i class="fas fa-exclamation-circle"></i> {{$message}}</p>
									@endforeach
								</ul>
							@endif
							<div class="control has-icons-left">
								<input type="email" class="input {{$errors->has('email')?'is-danger':''}}" name="email" value="{{ old('email') }}" required autofocus/>
								<span class="icon is-left {{$errors->has('email')?'has-text-danger':''}}">
									<i class="fa fa-envelope"></i>
								</span>
							</div>
						</div>
						<div class='field is-narrow'>
							<label for="password" class="label {{$errors->has('password')?'has-text-danger':''}}">{{__("Password")}}</label>
							@if($errors->has('password'))
								<ul class='has-text-danger is-size-7' style='list-style:none;'>
									@foreach($errors->get('password') as $message)
										<li><i class="fas fa-exclamation-circle"></i> {{$message}}</p>
									@endforeach
								</ul>
							@endif
							<div class="control has-icons-left">
								<input type="password" class="input {{$errors->has('password')?'is-danger':''}}" name="password" required/>
								<span class="icon is-left {{$errors->has('password')?'has-text-danger':''}}">
									<i class="fa fa-key"></i>
								</span>
							</div>
						</div>
						<div class='field'>
							<div class="control">
								<label class="checkbox">
									<input type='checkbox' name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
										  {{ __('Remember Me') }}
								</label>
							</div>
						</div>
						@if (Route::has('password.request'))
						<div class='field'>		
							<div class='control'>      
								<a href="{{ route('password.request') }}">
									{{ __('Forgot Your Password?') }}
								</a>
							</div> 
						</div>
                        @endif
						<div class="field is-grouped is-grouped-centered">
							<div class="control">
								<button type="submit" class="button is-success">
									<strong>{{ __('Login') }}</strong>
								</button>
							</div>
							
							<div class="control">
								<a href="/" class="button is-light">
									<strong>{{ __('Cancel') }}</strong>
								</a>
							</div>
							
							
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>    
@endsection
