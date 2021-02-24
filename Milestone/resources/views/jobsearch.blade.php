<!-- Page to search jobs -->

@extends('layouts/app')

@section('content')
<html>

	<body>
		<div class="container">
        	<div class="row justify-content-center">
            	<div class="col-md-12">
    				<div class="card">
    					<div class="card-header">Job Search</div>
        					<div class="card-body">
        						<form action="searchjobs" method="post">
        							{{csrf_field()}}
        							
        							<!-- User enters the property that they would like to search for -->
        							<label for="term" class="col-md-4 col-form-label text-md-right">
        								What would you like to search for?
        							</label>
        							
        							<!-- Select one of the job properties -->
        							<select name="searchTerm" id="term">
										<option value="title">Title</option>
										<option value="company">Company</option>
										<option value="salary">Salary</option>
										<option value="field">Field</option>
										<option value="skills">Skills</option>
										<option value="experience">Experience</option>
										<option value="location">Location</option>
									</select> <br>
									
									<!-- Database will query for jobs with similar field values to the entered val -->
									<label for="search" class="col-md-4 col-form-label text-md-right">
        								Enter Your Search
        							</label>
        							<input type="text" name="pattern" id="search">
        							<br><br>
        							
        							<!-- Submit button -->
        							<div class="col-md-8 offset-md-4">
                            			<input type="submit" value="Submit" class="btn btn-primary"/>
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