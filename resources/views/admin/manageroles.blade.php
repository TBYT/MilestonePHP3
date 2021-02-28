<!-- Page to suspend, restore, and delete users -->

<!DOCTYPE=html>
<html lang="en">

	@extends('layouts/app')
	<head>
		<title>Admin Page</title>
	</head>
	
	<body>
		@section('content')
		<div class="row justify-content-center">
        <div class="col-md-8">
            <div align="center" class="card">
                <div class="card-header"><h3>List of Users.</h3></div>
			<ul>
				<!-- all of the users in the database 
				        Display: Name, delete button, suspend/restore button -->
				@foreach ($users as $id => $person)
				<li>
				
				<!-- Begin Name -->
				<h4>
					Name: {{ $person->getName() }}
				</h4>
				
				<!-- Begin Delete -->
					<form action="delete" method="post">
						{{csrf_field()}}
						<input type="hidden" name="id" value="{{ $id }}"/>
						<input type="submit" value="Delete"/>
					</form>
					
					<!-- Begin Suspend/Restore -->
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
		</div>
		@endsection
	</body>
</html>