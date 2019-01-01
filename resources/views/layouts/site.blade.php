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
		<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
	@yield('scripts')
    </head>
    <body>
		@if (Route::has('login'))
		
			<nav class="navbar" role="navigation" aria-label="main navigation">
				
				<div class="navbar-brand">
					
						<a class="navbar-item" href="/">
							<img src='{{ asset('img/logo.png') }}' />
						</a>

					 <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarMenu">
						<span aria-hidden="true"></span>
						<span aria-hidden="true"></span>
						<span aria-hidden="true"></span>
					</a>
				</div>
				<div id="navbarMenu" class="navbar-menu">
					<div class="navbar-start">
						
						@foreach ($pageData->navItems as $nav)
							@if($nav->children()->count() > 0)
								<div class="navbar-item has-dropdown is-hoverable">
									<a class="navbar-link is-arrowless" href="{{$nav->uri=='/'? $nav->uri:'/'.$nav->uri}}">{{$nav->title}}</a>
									<div class="navbar-dropdown">
										@foreach($nav->children()->get() as $subNav)
											<a class="navbar-item" href="{{$nav->uri=='/'? $nav->uri:'/'.$nav->uri.'/'.$subNav->uri}}">{{$subNav->title}}</a>
											@if($subNav->children()->count() > 0)
												<hr class="navbar-divider">
												@foreach($subNav->children()->get() as $subNavChild)
												<a class="navbar-item has-icons-left" href="{{$nav->uri=='/'? $nav->uri:'/'.$nav->uri.'/'.$subNav->uri.'/'.$subNavChild->uri}}"><span class='icon has-text-grey-light' style='padding-right: 10px;'><i class="fas fa-long-arrow-alt-right"></i></span>{{' '.$subNavChild->title}}</a>
												@endforeach
												<hr class="navbar-divider">
											@endif
										@endforeach
									</div>
								</div>
							@else
								<a class="navbar-item" href="{{$nav->uri=='/'? $nav->uri:'/'.$nav->uri}}">{{$nav->title}}</a>
							@endif
							
						@endforeach
						
					</div>
				</div>
				<div class="navbar-end">
					<div class="navbar-item">
						
							
								
								@auth
								<p class='navbar-item'>Hi {!! explode(' ',Auth::user()->name)[0]!!}</p>
								<div class="buttons">
								<a class="button is-primary is-outlined" href="{{ url('/dashboard') }}"><strong>Member Area</strong></a>
								@else
									<div class="buttons">
									@if (Route::has('register'))
										@if($pageData->activeNav == 'register')
											<p class="button is-primary is-outlined" disabled><strong>Apply Today</strong></p>
										@else
											<a class="button is-primary is-outlined" href="{{ route('register') }}" ><strong>Apply Today</strong></a>
										@endif
									
									@endif
									
									@if($pageData->activeNav == 'login')
										<p class="button is-link is-outlined" disabled>Login</p>
									@else
										<a class="button is-link is-outlined" href="{{ route('login') }}" >Login</a>
									@endif

									
								@endauth
							
						</div>
					</div>
				</div>
			</nav>
		@endif
        <section class="section">
            <div class="container">
				@yield('content')
            </div>
        </section>
    </body>
</html>