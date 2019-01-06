@php

if(isset($dumpTop)){
	dump('############################################  Available Varibles On This Page  ############################################');
	dump('################## ensure you have (AT)php extract((array)$pageData) (AT)endphp in the top of your view  ##################');
	dump($pageData);
}

@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{(isset($pageData->page->title))? (($pageData->page->title != '')? $pageData->page->title.' | ':''):''}}Lakeview Estate</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/bulma-divider.min.css') }}" rel="stylesheet">
		<link href="{{ asset('css/style.css') }}" rel="stylesheet">
		
		<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
   <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    </head>
    <body>
		<div id="data" 
			 data-token="{{csrf_token()}}"
			 @if(isset($farm)) data-farm-id="{{$farm->id}}" @endif
			 
			 
			 ></div>
		<div id="token">@csrf</div>
		<script
  src="{{ asset('js/userArea.js')}}" ></script>
		@if (Route::has('login'))
		
			<nav class="navbar" role="navigation" aria-label="main navigation">
				
				<div class="navbar-brand">
					
						<a class="navbar-item" href="/">
							<img src='{{ asset('img/logo.png') }}' />
						</a>

					 <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navBar">
						<span aria-hidden="true"></span>
						<span aria-hidden="true"></span>
						<span aria-hidden="true"></span>
					</a>
				</div>
				<div class="navbar-menu">
					
				</div>
				<div class="navbar-end">
					
							
								
								@guest
									<div class="navbar-item">
										<div class="buttons">
											<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
												@if (Route::has('register'))
                                
													<a class="navbar-link" href="{{ route('register') }}">{{ __('Register') }}</a>
												@endif
										</div>
									</div>
								@else
								<div class="navbar-item">
									<a href="/issue/create" class="button is-primary is-fullwidth is-normal"><strong>Report A New Issue</strong></a>
								</div>
                            <div class="navbar-item">
								<div class='field has-addons'>
									<p class="control">
										<a class='nav-link button is-static is-outlined'>
											<span>{{ Auth::user()->name }} 0 </span><span class="icon"><i class="far fa-envelope"></i></span>
										</a>
									</p>
								</div>
							</div>
							<div class="navbar-item">
								<a class="nav-link button is-primary is-outlined" href="{{ route('logout') }}"
								   onclick="event.preventDefault();
												 document.getElementById('logout-form').submit();">
									{{ __('Logout') }}
								</a>

								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									@csrf
								</form>
							</div>  
                        @endguest
							
						</div>
					</div>
				</div>
			</nav>
		@endif
		<div id="modal">
			
		</div>
		@yield('scripts')
        <section class="section">
            <div class="container">
				<div class='columns'>
					<div class='column is-one-quarter has-background-light is-fullheight' id="dashboardSideNav">
						<aside class="menu">
							<p class="menu-label is-size-6">
							  General
							</p>
							<ul class="menu-list">
								<li><a href="{{url('/dashboard')}}" class="{{$pageData->activeNav=='dashboard'? 'is-active':''}}">Dashboard</a></li>
							  <li><a href="{{url('/farms')}}" class="{{$pageData->activeNav=='farms'? 'is-active':''}}">Farms</a></li>
							  <li><a href="{{url('/account')}}" class="{{$pageData->activeNav=='account'? 'is-active':''}}">Account</a></li>
							  <li><a href="{{url('/account/messages')}}" class="{{$pageData->activeNav=='messages'? 'is-active':''}}">Messages</a></li>
							</ul>
							<p class="menu-label is-size-6">
							  Administration
							</p>
							<ul class="menu-list">
							  <li>
								<a >Content</a>
								<ul class="subMenu">
								  <li><a>All Pages</a></li>
								  <li><a>New Page</a></li>
								</ul>
							  </li>
							  <li><a>Applications</a></li>
							  <li><a>Users</a></li>
							</ul>
						</aside>
					</div>
				
					<div class='column is-four-fifths top is-capitalized' id='container'>
						@include('layouts.notification')
						@yield('content')
					</div>
				</div>
				
            </div>
        </section>
    </body>
</html>

@php

if(isset($dumpBottom)){
	dump('############################################  Available Varibles On This Page  ############################################');
	dump('################## ensure you have (AT)php extract((array)$pageData) (AT)endphp in the top of your view  ##################');
	dump($pageData);
}

@endphp
