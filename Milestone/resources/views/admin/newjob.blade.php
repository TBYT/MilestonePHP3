<!-- Page to make new Job -->

@extends('layouts/app')

<<link rel="stylesheet" type="text/css" href="layouts/css.php">

<html>

	<style>
	   .center
	   {
 	       position: relative; 
 	       left: 35%; 
           color:red;
           text-align:justify;
	   }
	</style>
	
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
    							@if (isset($message))
    							<h1> {{ $message }}</h1>
    							@endif
    							<!-- Form to initialize each of the fields 
    							     This is almost identical to the edit job page... maybe merge the two? -->
                        		<form method="post" action="addjob">
                        			{{csrf_field()}}
                        			
                        			<!-- Begin Title -->
<!--                         			<div> -->
                            			<?php //if ($errors->first('title') != null) echo "<b class=\"center\">" . $errors->first('title') . "</b><br>"; ?>
<!--                         			</div> -->
                        			<label for="title" class="col-md-4 col-form-label text-md-right">Title</label>
                        			<input type="text" name="title" required minlength="6" maxlength="30" /><br>
                        			
                        			
                        			<!-- Begin Company -->
                        			
                        			<label for="company" class="col-md-4 col-form-label text-md-right">Company</label>
                        			<input type="text" name="company" required minlength="3" maxlength="30" /><br>
                        			
                        			<!-- Begin Salary -->
                        			
                        			<label for="salary" class="col-md-4 col-form-label text-md-right">Salary</label>
                        			<input type="number" name="salary" required min="10000" max="1000000" /><br>
                        			
                        			<!-- Begin Field -->
                        			
                        			<label for="field" class="col-md-4 col-form-label text-md-right">Job Field</label>
                        			<input type="text" name="field" required minlength="3" maxlength="30" /><br>
                        			
                        			<!-- Begin Skills -->
                        			
                        			<label for="skills" class="col-md-4 col-form-label text-md-right">Skills Required</label>
                        			<input type="text" name="skills" required minlength="3" maxlength="30" /><br>
                        			
                        			<!-- Begin Experience -->
                        			
                        			<label for="experience" class="col-md-4 col-form-label text-md-right">Experience Required</label>
                        			<input type="text" name="experience" required minlength="3" maxlength="30" /><br>
                        			
                        			<!-- Begin Location -->
                        			
                        			<label for="location" class="col-md-4 col-form-label text-md-right">Location</label>
                        			<input type="text" name="location" required minlength="5" maxlength="50" /><br>
                        		
                        			<!-- Begin Description -->	
                        			
                        			<label for="description" class="col-md-4 col-form-label text-md-right align-top">Description</label>
                        			<textarea rows="10" col="20" name="description" required minlength="10" maxlength="250" ></textarea><br><br>	
                        			
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