<!-- Page to display list of jobs -->

@extends('layouts/app')

<html>
	@section('content')
	<body>
		<div class="row justify-content-center">
        <div class="col-md-8">
            <div align="center" class="card">
                <div class="card-header"><h3>Admin List of Jobs.</h3></div>
                <!-- This is the result page for update and delete actions, 
                    so display message from those methods -->
                @if (isset($message))
             	<h1 align="center" class="card-header">{{ $message }} </h1>
             	@endif
             	<!-- Admin Actions -->
			@if (session()->get('isAdmin'))
			<ul>
				<!-- For each job in the list, show its title and the two buttons -->
				@foreach ($jobs as $id => $job)
				<li>
				<h4>
					Title: {{ $job->getTitle() }}
					
					</h4>
					<!-- Delete Form -->
					<form action="deletejob" method="post">
						{{csrf_field()}}
						<input type="hidden" name="id" value="{{ $id }}"/>
						<input type="submit" value="Delete"/>
					</form>
					<!-- Edit Form -->
					<form action="editjob" method="post">
						{{csrf_field()}}
						<input type="hidden" name="id" value="{{ $id }}"/>
						<input type="submit" value="Edit"/>
					</form>
				</li>
				@endforeach
				<!-- Form to create a new job at the bottom of the page -->
				<form action="newjob" method="get">
					<label for="new">Create a new job</label><br>
					<input type="submit" value="Create New"/>
				</form>
			</ul>
			<hr>
			@endif
			<div class="card-header"><h3>List of Applied Jobs.</h3></div>
			@if (count($appliedjobs) == 0)
			<h2>you have not applied to any jobs</h2>
			@endif
			<ul>
				<!-- Each job in the list of results -->
				<!-- TODO: need an empty list error page -->
				@foreach ($appliedjobs as $id => $applied)
				<li>
				
				<!-- Main title: job title, subheading: company -->
				<h4>
					Title: {{ $applied->getTitle() }}
				</h4>
				<h5>Company: {{ $applied->getCompany() }}</h5>
				<h6><i>applied</i></h5>
				<!-- Button to view full job details -->
					<form action="viewjob" method="post">
						{{csrf_field()}}
						<input type="hidden" name="id" value="{{ $id }}"/>
						<input type="submit" value="View"/>
					</form>
				</li>
				@endforeach
			</ul>
			</div>
		</div>
	</body>
	@endsection
</html>