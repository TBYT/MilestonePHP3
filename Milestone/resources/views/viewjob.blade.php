<!-- Page to view the full details of one job -->

@extends('layouts/app')

<<link rel="stylesheet" type="text/css" href="layouts/css.php">

<html>
	<head>
	</head>
	
	@section('content')
	<body>
    	<div class="container">
        	<div class="row justify-content-center">
            	<div class="col-md-8">
    				<div class="card">
    					<div class="card-header">View Job</div>
    						<div class="card-body">
    						
    								<!-- Echo each of the job properties
    								    Main heading: Title, Subheading: Company -->
                        			<h3>Title: {{ $job->getTitle() }}</h3><br>
                        			<h4>Company: {{ $job->getCompany() }}</h4><br>
                        			<a>Salary: {{ $job->getSalary() }} </a><br>
                        			<a>Field: {{ $job->getField() }}</a><br>
                        			<a>Skills: {{ $job->getSkills() }}</a><br>
                        			<a>Experience {{ $job->getExperience() }}</a><br>
                        			<a>Location: {{ $job->getLocation() }}</a><br>
                        			<p>Description: {{ $job->getDescription() }}</p><br><br>
                        			
                        			<!-- Button to apply (does nothing currently) -->
                        			@if(!$isApplied)
                            			<form action="apply" method="post">
                            			{{csrf_field()}}
                            				<input type="hidden" name="id" value="{{ $id }}"/>
                                			<div class="col-md-8 offset-md-4">
                                    			<input type="submit" value="Apply" class="btn btn-primary"/>
                                			</div>
                                		</form>
                            		@endif
                            		
                            		<!-- Button to go make another search (Should return list view?) -->
                            		<form action="jobsearch" method="get">
                            			<div class="col-md-8 offset-md-4">
                                			<input type="submit" value="Return To Search" class="btn btn-primary"/>
                            			</div>
                            		</form>
     						</div>
                        </div>
                 	</div>
                 </div>
          	</div>
	</body>
	@endsection
</html>