@extends('layouts/app')

<html>
	@section('content')
	<body>
		<div class="row justify-content-center">
        <div class="col-md-8">
            <div align="center" class="card">
                <div class="card-header"><h3>List of Jobs.</h3></div>
                @if (isset($message))
             	<h1>{{ $message }} </h1>
             	@endif
			<ul>
				@foreach ($jobs as $id => $job)
				<li>
				<h4>
					Title: {{ $job->getTitle() }}
					
					</h4>
					<form action="deletejob" method="post">
						{{csrf_field()}}
						<input type="hidden" name="id" value="{{ $id }}"/>
						<input type="submit" value="Delete"/>
					</form>
					
					<form action="editjob" method="post">
						{{csrf_field()}}
						<input type="hidden" name="id" value="{{ $id }}"/>
						<input type="submit" value="Edit"/>
					</form>
				</li>
				@endforeach
				<form action="newjob" method="get">
					<label for="new">Create a new job</label><br>
					<input type="submit" value="Create New"/>
				</form>
			</ul>
			</div>
		</div>
	</body>
	@endsection
</html>