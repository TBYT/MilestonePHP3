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
    					<div class="card-header">Edit Job</div>
    
    						<div class="card-body">
    							@if (isset($message))
    							<h1>{{ $message }}</h1>
    							@endif
                        		<form method="post" action="doeditjob">
                        			{{csrf_field()}}
                        			<label for="title" class="col-md-4 col-form-label text-md-right">Title</label>
                        			<input type="text" name="title" value="{{ $job->getTitle() }}"/><br>
                        			<label for="company" class="col-md-4 col-form-label text-md-right">Company</label>
                        			<input type="text" name="company" value="{{ $job->getCompany() }}"/><br>
                        			<label for="salary" class="col-md-4 col-form-label text-md-right">Salary</label>
                        			<input type="text" name="salary" value="{{ $job->getSalary() }}"/><br>
                        			<label for="field" class="col-md-4 col-form-label text-md-right">Job Field</label>
                        			<input type="text" name="field" value="{{ $job->getField() }}"/><br>
                        			<label for="skills" class="col-md-4 col-form-label text-md-right">Skills Required</label>
                        			<input type="text" name="skills" value="{{ $job->getSkills() }}"/><br>
                        			<label for="experience" class="col-md-4 col-form-label text-md-right">Experience Required</label>
                        			<input type="text" name="experience" value="{{ $job->getExperience() }}"/><br>
                        			<label for="location" class="col-md-4 col-form-label text-md-right">Location</label>
                        			<input type="text" name="location" value="{{ $job->getLocation() }}"/><br>
                        			<!-- Had to edit the css for this to make the label top-align -->
                        			<label for="description" class="col-md-4 col-form-label text-md-right align-top">Description</label>
                        			<textarea rows="10" col="20" name="description">{{ $job->getDescription() }}</textarea><br><br>
                        			<input type="hidden" name="id" value="{{ $id }}"/>
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