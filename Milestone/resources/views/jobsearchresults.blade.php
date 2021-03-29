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
             	<div class="table"</div>
			<table>
				<tr>
					<th>Title</th>
					<th>Company</th>
					<th>View Details</th>
				</tr>
				<!-- Each job in the list of results -->
				<!-- TODO: need an empty list error page -->
				@foreach ($jobs as $id => $job)
					<tr>
				        <!-- Main title: job title, subheading: company -->
						<td>Title: {{ $job->getTitle() }} </td>
						<td>Company: {{$job->getCompany() }}</td>>
						<td>View Details: 
							<!-- Button to view full job details -->
							<form action="viewjob" method="post">
								{{csrf_field()}}
								<input type="hidden" name="id" value="{{ $id }}"/>
								<input type="submit" value="View"/>
							</form>
						</td>
					</tr>
				@endforeach
			</table>
			</div>
		</div>
	</body>
	@endsection
</html>
