<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/style.css') }}" rel="stylesheet">
		<link href="{{ asset('css/bulma-radio-checkbox.min.css') }}" rel="stylesheet">
	</head>
	<body>
		@yield('content')
	</body>
</html>