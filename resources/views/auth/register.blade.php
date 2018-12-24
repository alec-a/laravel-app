@extends('layouts.site')

@section('scripts')
<script src="{{ asset('js/dist/jquery.inputmask.bundle.js') }}" type="text/javascript"></script>


@endsection

@section('content')
<script src="{{ asset('js/register.js') }}" type="text/javascript"></script>
		<form method="POST" action="{{ route('register') }}">
            <div class="card">
				<header class="card-header">
					<p class="card-header-title has-text-centered is-inline">Apply To Become a Member Of Lakeview Estate</p>
				</header>
				<div class="card-content">
				<div class='columns'>
					<div class='column is-fullheight'>
						<div class="card is-fullheight" style="height: 100%;">
							<div class="card-content">
								<div class="content">


										@csrf

										<div class="field">
											<label for="name" class="label {{ $errors->has('name') ? ' has-text-danger' : '' }}">{{ __('Name') }}</label>
											@if ($errors->has('name'))
												<ul class='has-text-danger is-size-7' style='list-style:none;'>
												@foreach($errors->get('name') as $message)
												<li><i class="fas fa-exclamation-circle"></i> {{$message}}</p>
												@endforeach
												</ul>
											@endif
											<div class="control has-icons-left">
												<input type="text" class="input {{ $errors->has('name') ? ' is-danger' : '' }}" name="name" value="{{ old('name') }}"  autofocus>
												<span class="icon is-left {{ $errors->has('name') ? ' has-text-danger' : '' }}"><i class="fas fa-signature "></i></span>
											</div>
										</div>

										<div class="field">
											<label for="email" class="label {{ $errors->has('email') ? ' has-text-danger' : '' }}">{{ __('E-Mail Address') }}</label>
											@if ($errors->has('email'))
												<ul class='has-text-danger is-size-7' style='list-style:none;'>
												@foreach($errors->get('email') as $message)
												<li><i class="fas fa-exclamation-circle"></i> {{$message}}</p>
												@endforeach
												</ul>
											@endif
											<div class="control has-icons-left">
												<input type="email" class="input {{ $errors->has('email') ? ' is-danger' : '' }}" name="email" value="{{ old('email') }}" >
												<span class="icon is-left {{ $errors->has('email') ? ' has-text-danger' : '' }}">
													<i class="fas fa-envelope"></i>
												</span>
											</div>
										</div>

										<div class="field">
											<label for="password" class="label {{ $errors->has('password') ? ' has-text-danger' : '' }}">{{ __('Password') }}</label>
											@if ($errors->has('password'))
												<ul class='has-text-danger is-size-7' style='list-style:none;'>
												@foreach($errors->get('password') as $message)
												<li><i class="fas fa-exclamation-circle"></i> {{$message}}</p>
												@endforeach
												</ul>
											@endif
											<div class="control has-icons-left">
												<input type="password" class="input {{ $errors->has('password') ? ' is-danger' : '' }}" name="password" >
												<span class="icon is-left {{ $errors->has('password') ? ' has-text-danger' : '' }}">
													<i class="fas fa-key"></i>
												</span>
											</div>
										</div>

										<div class="field">
											<label for="password-confirm" class="label {{ $errors->has('password') ? ' has-text-danger' : '' }}">{{ __('Confirm Password') }}</label>

											<div class="control has-icons-left">
												<input type="password" class="input {{ $errors->has('password') ? ' is-danger' : '' }}" name="password_confirmation" >
												<span class="icon is-left {{ $errors->has('password') ? ' has-text-danger' : '' }}">
													<i class="fas fa-key"></i>
												</span>
											</div>
										</div>

										

								</div>
							</div>
						</div>
					</div>
					<div class='column'>
						<div class="card" style="height:100%;">
							
							<div class="card-content">
								<div class="content">
									<div class="field is-horizontal">
										<div class='field-label is-small'>
											<label for='fsUk' class='label {{ $errors->has('fsUk') ? ' has-text-danger' : '' }}'>Fs-Uk Username</label>
										</div>
										<div class='field-body'>
											<div class="field">
												@if ($errors->has('fsUk'))
													<ul class='has-text-danger is-size-7' style='list-style:none;'>
													@foreach($errors->get('fsUk') as $message)
													<li><i class="fas fa-exclamation-circle"></i> {{$message}}</p>
													@endforeach
													</ul>
												@endif
												<p class="control has-icons-left">
													<input type="text" class="input {{ $errors->has('fsUk') ? ' is-danger' : '' }}" name="fsUk" value="{{ old('fsUk') }}"/>
													<span class="icon is-left {{ $errors->has('fsUk') ? ' has-text-danger' : '' }}">
														<i class="fas fa-user"></i>
													</span>
												</p>
											</div>
										</div>
									</div>
									
									<div class="field is-horizontal">
										<div class='field-label is-normal'>
											<label for='birthday' class='label {{ $errors->has('birthday') ? ' has-text-danger' : '' }}'>Birthday</label>
										</div>
										<div class='field-body'>
											<div class="field is-narrow">
												@if ($errors->has('birthday'))
													<ul class='has-text-danger is-size-7' style='list-style:none;'>
													@foreach($errors->get('birthday') as $message)
													<li><i class="fas fa-exclamation-circle"></i> {{$message}}</p>
													@endforeach
													</ul>
												@endif
												<p class="control has-icons-left">
													<input type="text" class="input {{ $errors->has('birthday') ? ' is-danger' : '' }}" name="birthday" placeholder="DD/MM/YYYY" value="{{ old('birthday') }}"/>
													<span class="icon is-left {{ $errors->has('birthday') ? ' has-text-danger' : '' }}">
														<i class="fas fa-birthday-cake"></i>
													</span>
												</p>
											</div>
										</div>
									</div>
									
									<div class="field is-horizontal">
										<div class='field-label is-normal'>
											<label class='label {{ ($errors->has('country')||$errors->has('timezone')) ? ' has-text-danger' : '' }}'>Location</label>
										</div>
										<div class='field-body'>
											
											<div class="field">
												@if ($errors->has('country'))
													<ul class='has-text-danger is-size-7' style='list-style:none;'>
														@foreach($errors->get('country') as $message)
														<li><i class="fas fa-exclamation-circle"></i> {{$message}}</p>
														@endforeach
													</ul>
												@endif
												<div class="control has-icons-left">
													<div class="select is-fullwidth {{ $errors->has('country') ? ' is-danger' : '' }}">
														<select name="country">
															<option {{empty(old('country'))? 'selected':''}}>Please Select...</option>
															@foreach ($pageData->data->countries as $val => $country)
															<option value="{{$val}}" {{(!empty(old('country'))&&old('country') == $val)? 'selected':''}}>{{$country}}</option>
															@endforeach
														</select>
													</div>
													<span class="icon is-left {{ $errors->has('country') ? ' has-text-danger' : '' }}">
														<i class="fas fa-globe"></i>
													</span>
												</div>
												
											</div>
											<div class="field">
												@if ($errors->has('timezone'))
													<ul class='has-text-danger is-size-7' style='list-style:none;'>
														@foreach($errors->get('timezone') as $message)
														<li><i class="fas fa-exclamation-circle"></i> {{$message}}</p>
														@endforeach
													</ul>
												@endif
												<div class="control has-icons-left">
													<div class="select is-fullwidth {{ $errors->has('timezone') ? ' is-danger' : '' }}">
														<select name="timezone">
															<option {{empty(old('timezone'))? 'selected':''}}>Please Select...</option>
															@foreach ($pageData->data->timezones as $val => $timezone)
															<option value="{{$val}}" {{(!empty(old('timezone'))&&old('timezone') == $val)? 'selected':''}}>{{$timezone}}</option>
															@endforeach
														</select>
													</div>
													<span class="icon is-left {{ $errors->has('timezone') ? ' has-text-danger' : '' }}">
														<i class="fas fa-clock"></i>
													</span>
												</div>
											</div>
										</div>
									</div>
									
									<div class="field is-horizontal">
										<div class='field-label is-normal'>
											<label class='label {{ $errors->has('english')||$errors->has('discord')||$errors->has('mic') ? ' has-text-danger' : '' }}'>Do You</label>
										</div>
										<div class='field-body'>
											<div class="field {{$errors->has('english')? 'has-text-danger':''}}">
												<label class="label is-small {{$errors->has('english')? 'has-text-danger':''}}">Speak English</label>
												<div class="control">
													<label class="radio">
													<input type="radio" name="english" {{old('english') == 'on'?'checked':''}}>
													Yes
												  </label>
												  <label class="radio">
													<input type="radio" name="english" value='off' {{old('english') == 'off'?'checked':''}}>
													No
												  </label>
												</div>
											</div>
											<div class="field {{$errors->has('discord')? 'has-text-danger':''}}">
												<label class="label is-small {{$errors->has('discord')? 'has-text-danger':''}}">Have Discord</label>
												<div class="control">
													<label class="radio">
													<input type="radio" name="discord" {{old('discord') == 'on'?'checked':''}}>
													Yes
												  </label>
												  <label class="radio">
													<input type="radio" name="discord" value='off' {{old('discord') == 'off'?'checked':''}}>
													No
												  </label>
													
												</div>
											</div>
											<div class="field {{$errors->has('mic')? 'has-text-danger':''}}">
												<label class="label is-small {{$errors->has('mic')? 'has-text-danger':''}}">Have a Mic</label>
												<div class="control">
													<label class="radio">
													<input type="radio" name="mic" {{old('mic') == 'on'?'checked':''}}>
													Yes
												  </label>
												  <label class="radio">
													<input type="radio" name="mic" value='off' {{old('mic') == 'off'?'checked':''}}>
													No
												  </label>
												</div>
											</div>
										</div>
									</div>
									
									<div class="field is-horizontal">
										<div class='field-label is-normal'>
											
										</div>
										<div class='field-body'>
											<div class="field {{$errors->has('otherServer')? 'has-text-danger':''}}">
												<label class="label is-small {{$errors->has('otherServer')? 'has-text-danger':''}}">Are You Part Of Another Server/Team</label>
												<div class="control">
													<label class="radio">
													<input type="radio" name="otherServer" {{old('otherServer') == 'on'?'checked':''}}>
													Yes
												  </label>
												  <label class="radio">
													<input type="radio" name="otherServer" value='off' {{old('otherServer') == 'off'?'checked':''}}>
													No
												  </label>
												</div>
											</div>
											<div class="field {{$errors->has('experience')? 'has-text-danger':''}}">
												<label class="label is-small {{$errors->has('experience')? 'has-text-danger':''}}">Do You Have Any Multiplayer/Dedicated Server Experience?</label>
												<div class="control">
													<label class="radio">
													<input type="radio" name="experience" {{old('experience') == 'on'?'checked':''}}>
													Yes
												  </label>
												  <label class="radio">
													<input type="radio" name="experience" value='off' {{old('experience') == 'off'?'checked':''}}>
													No
												  </label>
												</div>
											</div>
										</div>
									</div>
									
									<div class="field is-horizontal">
										<div class='field-label is-normal'>
											
										</div>
										<div class='field-body'>
											<div class="field is-fullwidth {{$errors->has('donate')? 'has-text-danger':''}}">
												<label class="label is-normal {{$errors->has('donate')? 'has-text-danger':''}}">Are You Willing To Donate Towards The Running Costs Of The Server?</label>
												<div class="control">
													<label class="radio">
													<input type="radio" name="donate" {{old('donate') == 'off'?'checked':''}}>
													Yes
												  </label>
												  <label class="radio">
													<input type="radio" name="donate" value='off' {{old('donate') == 'off'?'checked':''}}>
													No
												  </label>
												</div>
											</div>
										</div>
										</div>
									</div>

									
								</div>
							</div>
						</div>
					</div>
					<div class="columns">
						<div class="column">
							<div class="card">
								
								<div class="card-content">
									<div class="field">
										<label class="label {{$errors->has('about')? 'has-text-danger':''}}" for="about">Tell Us A Bit About Yourself And Who You Are</label>
										<div class="control">
											<textarea class="textarea {{$errors->has('about')? 'is-danger':''}}" name="about">{{old('about')}}</textarea>
											
										</div>
									</div>
									<div class="field">
										<label class="label {{$errors->has('whyPartOfTeam')? 'has-text-danger':''}}" for="whyPartOfTeam">What Would You Like To Get Out Of Being A Part Of Our Team?</label>
										<div class="control ">
											<textarea class="textarea {{$errors->has('whyPartOfTeam')? 'is-danger':''}}" name="whyPartOfTeam">{{old('whyPartOfTeam')}}</textarea>
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class='columns'>
						<div class="column">
							<div class="card">
								<div class="card-content">
									<div class="content">
										<div class="field is-grouped is-grouped-centered">
											<div class="control">
												<button type="submit" class="button is-success">
													<strong>{{ __('Apply') }}</strong>
												</button>
											</div>
											<div class='control'>
												<button type="reset" class="button is-light">
													clear
												</button>

											</div>

										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>

			
 </form>
@endsection
