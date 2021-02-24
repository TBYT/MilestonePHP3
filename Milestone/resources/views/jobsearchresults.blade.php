<!-- Page to display search results -->

@extends('layouts/app')

<html>
	@section('content')
	<body>
		<div class="row justify-content-center">
        <div class="col-md-8">
            <div align="center" class="card">
                <div class="card-header"><h3>Search Results.</h3></div>
                @if (isset($message))
             	<h1>{{ $message }} </h1>
             	@endif
			<ul>
				<!-- Each job in the list of results -->
				<!-- TODO: need an empty list error page -->
				@foreach ($jobs as $id => $job)
				<li>
				
				<!-- Main title: job title, subheading: company -->
				<h2>
					Title: {{ $job->getTitle() }}
				</h2>
				<h5>Company: {{$job->getCompany() }}</h5>
				<!-- Button to view full job details -->
					<form action="viewjob" method="post">
						{{csrf_field()}}
						<input type="hidden" name="id" value="{{ $id }}"/>
						<input type="submit" value="View"/>
					</form>
				@endforeach
			</ul>
			</div>
		</div>
	</body>
	@endsection
</html>