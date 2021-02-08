<!DOCTYPE=html>
<html lang="en">

	@extends('layouts/app')
	<head>
		<title>Admin Page</title>
	</head>
	
	<body>
		@section('content')
		<div style="color:green">
			<h1>Here is a list of users</h1>
			<ul>
				@foreach ($users as $id => $person)
				<li>
					Name: {{ $person->getName() }}
					<form action="delete" method="post">
						{{csrf_field()}}
						<input type="hidden" name="id" value="{{ $id }}"/>
						<input type="submit" value="Delete"/>
					</form>
					
					@if ($person->isSuspended())
					<form action="restore" method="post">
						{{csrf_field()}}
						<input type="hidden" name="id" value="{{ $id }}"/>
						<input type="submit" value="Restore"/>
					</form>
					
					@else
					<form action="suspend" method="post">
						{{csrf_field()}}
						<input type="hidden" name="id" value="{{ $id }}"/>
						<input type="submit" value="Suspend"/>
					</form>
					@endif
				</li>
				@endforeach
			</ul>
		</div>
		@endsection
	</body>
</html>