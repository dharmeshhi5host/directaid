<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Developed with Love!">
		<meta name="Author" content="Developed with Love!">
		<meta name="Keywords" content="Developed with Love!"/>
		@include('admin.layouts.head')
	</head>

	<body class="main-body dark-theme">
		<!-- Loader -->

		<!-- /Loader -->
		@yield('content')
		@include('admin.layouts.footer-scripts')
	</body>
</html>
