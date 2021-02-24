<!-- Page to edit an existing job -->

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
                        		<form method="post" action="doeditjob">
                        			{{csrf_field()}}
                        			
                        			<!-- Begin Title -->
                        			<label for="title" class="col-md-4 col-form-label text-md-right">Title</label>
                        			<input type="text" name="title" value="{{ $job->getTitle() }}"/><br>
                        			<?php echo $errors->first('title'); ?>
                        			
                        			<!-- Begin Company -->
                        			<label for="company" class="col-md-4 col-form-label text-md-right">Company</label>
                        			<input type="text" name="company" value="{{ $job->getCompany() }}"/><br>
                        			<?php echo $errors->first('company'); ?>
                        			
                        			<!-- Begin Salary -->
                        			<label for="salary" class="col-md-4 col-form-label text-md-right">Salary</label>
                        			<input type="text" name="salary" value="{{ $job->getSalary() }}"/><br>
                        			<?php echo $errors->first('salary'); ?>
                        			
                        			<!-- Begin Field -->
                        			<label for="field" class="col-md-4 col-form-label text-md-right">Job Field</label>
                        			<input type="text" name="field" value="{{ $job->getField() }}"/><br>
                        			<?php echo $errors->first('field'); ?>
                        			
                        			<!-- Begin Skills -->
                        			<label for="skills" class="col-md-4 col-form-label text-md-right">Skills Required</label>
                        			<input type="text" name="skills" value="{{ $job->getSkills() }}"/><br>
                        			
                        			<!-- Begin Experience -->
                        			<label for="experience" class="col-md-4 col-form-label text-md-right">Experience Required</label>
                        			<input type="text" name="experience" value="{{ $job->getExperience() }}"/><br>
                        			<?php echo $errors->first('experience'); ?>
                        			
                        			<!-- Begin Location -->
                        			<label for="location" class="col-md-4 col-form-label text-md-right">Location</label>
                        			<input type="text" name="location" value="{{ $job->getLocation() }}"/><br>
                        			<?php echo $errors->first('location'); ?>
                        			
                        			<!-- Begin Description -->
                        			<!-- Had to edit the css for this to make the label top-align -->
                        			<label for="description" class="col-md-4 col-form-label text-md-right align-top">Description</label>
                        			<textarea rows="10" col="20" name="description">{{ $job->getDescription() }}</textarea><br><br>
                        			<?php echo $errors->first('description'); ?>
                        			
                        			<!-- Pass job id to the controller -->
                        			<input type="hidden" name="id" value="{{ $id }}"/>
                        			
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