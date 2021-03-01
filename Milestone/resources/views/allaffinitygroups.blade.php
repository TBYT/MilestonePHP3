<!-- Page to display list of affinity groups -->

@extends('layouts/app')

<html>
	@section('content')
	<body>
		<div class="row justify-content-center">
        <div class="col-md-8">
            <div align="center" class="card">
                <div class="card-header"><h3>List of Affinity Groups.</h3></div>
                <!-- This is the result page for update and delete actions, 
                    so display message from those methods -->
                @if (isset($message))
             	<h1>{{ $message }} </h1>
             	@endif
			<ul>
				<!-- For each group in the list, show its name and the three buttons -->
				@foreach ($groups as $id => $group)
				<li>
				<h4>Group Name: {{ $group[0] }}</h4>
					
					<!-- View Form -->
					<form action="viewaffinitygroup" method="get">
						{{csrf_field()}}
						<input type="hidden" name="id" value="{{ $id }}"/>
						<input type="submit" value="View"/>
					</form>
					
					<!-- Admin Actions -->
					@if (session()->get('isAdmin'))
						<span>
        					<!-- Delete Form -->
        					<form action="deleteaffinitygroup" method="post">
        						{{csrf_field()}}
        						<input type="hidden" name="id" value="{{ $id }}"/>
        						<input type="submit" value="Delete"/>
        					</form>
        					<!-- Edit Form -->
        					<form action="editaffinitygroup" method="post">
        						{{csrf_field()}}
        						<input type="hidden" name="id" value="{{ $id }}"/>
        						<input type="submit" value="Edit"/>
        					</form>
						</span>
					@endif
				</li>
				@endforeach
				
				@if (session()->get('isAdmin'))
    				<!-- Form to create a new affinity group at the bottom of the page -->
    				<form action="newaffinitygroup" method="get">
    					<label for="new">Create a new affinity group</label><br>
    					<input type="submit" value="Create New"/>
    				</form>
				@endif
			</ul>
			</div>
		</div>
	</body>
	@endsection
</html>