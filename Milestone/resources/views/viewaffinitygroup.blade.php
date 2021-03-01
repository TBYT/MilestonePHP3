<!-- Page to show portfolio search form and results -->

@extends('layouts/app')

<html>
@section('content')
<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">View Portfolio</div>
					<div class="card-body" align="center">
						<!-- Name -->
						<h3 class="card-header">Name: {{ $group['name'] }}</h3>
						<div class="card-body border border-secondary">
							<p class="center"> {{ $group['description'] }} </p>
							<hr>
							
							<h3> Members</h3>
							<ul>
							
    							<!-- Display each education's details -->
    							@if (count($users) == 0)
    							<h5>There are no users in this group. Join and become the first!</h5>
    							@endif
    							@foreach ($users as $id => $user) 
    							<li> {{ $user }} </li>
    							 @endforeach
							
							</ul>

							@if ($inGroup)
							<form action="leaveaffinitygroup" method="post">
								{{ csrf_field() }}
								<input type="hidden" value="{{ $groupID }}" name="id"/>
								<label for="leave">Leave This Group:</label><br>
								<input type="submit" value="Leave Group" id="leave"/>
							</form>
							@else
							<form action="joinaffinitygroup" method="post">
								{{ csrf_field() }}
								<input type="hidden" value="{{ $groupID }}" name="id"/>
								<label for="join">Join This Group:</label><br>
								<input type="submit" value="Join Group" id="join"/>
							</form>
							@endif
							<br><br>
							<form action="showallaffinitygroups" method="get">
								{{ csrf_field() }}
								<input type="hidden" value="{{ $groupID }}" name="id"/>
								<label for="join">Go Back</label><br>
								<input type="submit" value="Return" id="join"/>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
@endsection
</html>