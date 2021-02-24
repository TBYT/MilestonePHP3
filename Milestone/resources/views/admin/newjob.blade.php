<!-- Page to make new Job -->

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
    					<div class="card-header">Add Job</div>
    
    						<div class="card-body">
    							<!-- Form to initialize each of the fields 
    							     This is almost identical to the edit job page... maybe merge the two? -->
                        		<form method="post" action="addjob">
                        			{{csrf_field()}}
                        			
                        			<!-- Begin Title -->
                        			<label for="title" class="col-md-4 col-form-label text-md-right">Title</label>
                        			<input type="text" name="title"/><br>
                        			<?php echo $errors->first('title') . "<br>"; ?>
                        			
                        			<!-- Begin Company -->
                        			<label for="company" class="col-md-4 col-form-label text-md-right">Company</label>
                        			<input type="text" name="company"/><br>
                        			<?php echo $errors->first('company') . "<br>"; ?>
                        			
                        			<!-- Begin Salary -->
                        			<label for="salary" class="col-md-4 col-form-label text-md-right">Salary</label>
                        			<input type="text" name="salary"/><br>
                        			<?php echo $errors->first('salary') . "<br>"; ?>
                        			
                        			<!-- Begin Field -->
                        			<label for="field" class="col-md-4 col-form-label text-md-right">Job Field</label>
                        			<input type="text" name="field"/><br>
                        			<?php echo $errors->first('field') . "<br>"; ?>
                        			
                        			<!-- Begin Skills -->
                        			<label for="skills" class="col-md-4 col-form-label text-md-right">Skills Required</label>
                        			<input type="text" name="skills"/><br>
                        			<?php echo $errors->first('skills') . "<br>"; ?>
                        			
                        			<!-- Begin Experience -->
                        			<label for="experience" class="col-md-4 col-form-label text-md-right">Experience Required</label>
                        			<input type="text" name="experience"/><br>
                        			<?php echo $errors->first('experience') . "<br>"; ?>
                        			
                        			<!-- Begin Location -->
                        			<label for="location" class="col-md-4 col-form-label text-md-right">Location</label>
                        			<input type="text" name="location"/><br>
                        			<?php echo $errors->first('location') . "<br>"; ?>
                        		
                        			<!-- Begin Description -->	
                        			<!-- Had to edit the css for this to make the label top-align -->
                        			<label for="description" class="col-md-4 col-form-label text-md-right align-top">Description</label>
                        			<textarea rows="10" col="20" name="description"></textarea><br><br>	
                        			<?php echo $errors->first('description') . "<br>"; ?>
                        			
                        			<!-- Submit Button -->
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