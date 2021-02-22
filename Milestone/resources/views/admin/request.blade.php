@extends('layouts\app')

@section('content')
<html>
	<body>
		<div class="row justify-content-center">
        	<div class="col-md-8">
            	<div align="center" class="card">
                	<div class="card-header"><h3>List of Users.</h3></div>
						<ol>
							@foreach ($users as $id => $person)
							<form action="displayuser" method="post">
								{{csrf_field()}}
								<h3>{{ $person }}</h3>
								<input type="submit" value="View Request">
								<input type="hidden" name="id" value = "{{ $id }}">
								<input type="hidden" name="name" value="{{ $person }}">
							</form>
							@endforeach
						</ol>
					</div>
				</div>
			</div>
	</body>
</html>
@endsection