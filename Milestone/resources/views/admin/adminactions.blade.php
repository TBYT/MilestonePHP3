<!-- Page displays the different actions that administrators can take -->

@extends('layouts/app') 

@section('content')
<html>
	<body>
	<div class="container">
    	<div class="row justify-content-center">
        	<div class="col-md-8">
				<div class="card">
					<div class="card-header">Admin Access</div>
						<div class="card-body">
						
							@if (isset($message))
							<h2>{{ $message }}</h2>
							@endif
							
							<!-- Button to open user role page -->
							<form method="get" action="roles">
								<label for="roles">Suspend or update users</label><br>
            					<button id="roles">User Roles</button>
            				</form>
            				<!-- Button to open job listings page -->
            				<form method="get" action="showalljobs">
            					<label for="job">Add or edit job listings</label><br>
            					<button id="job">Job Listings</button>
            				</form>
            				<!-- Button to open affinity groups page -->
            				<form method="get" action="showallaffinitygroups">
            					<label for="group">Add or edit Affinity Groups</label><br>
            					<button id="group">Affinity Groups</button>
            				</form>
            				<!-- Not Implemented <form method="get" action="portfoliorequest">
            					<label for="requests">Approve or deny user portfolio edits</label><br>
            					<button id="requests">User Requests</button>
            				</form> -->
            			</div>
            		</div>
            	</div>
            </div>
     	</div>
	</body>
</html>
@endsection