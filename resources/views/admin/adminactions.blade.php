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