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
                        			<div>
                            			<?php if ($errors->first('title') != null) echo "<b class=\"center\">" . 
                            			     $errors->first('title') . "</b><br>"; ?>
                        			</div>
                        			<label for="title" class="col-md-4 col-form-label text-md-right">Title</label>
                        			<input type="text" name="title"/><br>
                        			
                        			
                        			<!-- Begin Company -->
                        			<div>
                            			<?php if ($errors->first('company') != null) echo "<b class=\"center\">" 
                                            . $errors->first('company') . "</b><br>"; ?>
                        			</div>
                        			<label for="company" class="col-md-4 col-form-label text-md-right">Company</label>
                        			<input type="text" name="company"/><br>
                        			
                        			<!-- Begin Salary -->
                        			<div>
                            			<?php if ($errors->first('salary') != null) echo "<b class=\"center\">" 
                                            . $errors->first('salary') . "</b><br>"; ?>
                        			</div>
                        			<label for="salary" class="col-md-4 col-form-label text-md-right">Salary</label>
                        			<input type="text" name="salary"/><br>
                        			
                        			<!-- Begin Field -->
                        			<div>
                            			<?php if ($errors->first('field') != null) echo "<b class=\"center\">" 
                                            . $errors->first('field') . "</b><br>"; ?>
                        			</div>
                        			<label for="field" class="col-md-4 col-form-label text-md-right">Job Field</label>
                        			<input type="text" name="field"/><br>
                        			
                        			<!-- Begin Skills -->
                        			<div>
                            			<?php if ($errors->first('skills') != null) echo "<b class=\"center\">" 
                                            . $errors->first('skills') . "</b><br>"; ?>
                        			</div>
                        			<label for="skills" class="col-md-4 col-form-label text-md-right">Skills Required</label>
                        			<input type="text" name="skills"/><br>
                        			
                        			<!-- Begin Experience -->
                        			<div>
                            			<?php if ($errors->first('experience') != null) echo "<b class=\"center\">" 
                                            . $errors->first('experience') . "</b><br>"; ?>
                        			</div>
                        			<label for="experience" class="col-md-4 col-form-label text-md-right">Experience Required</label>
                        			<input type="text" name="experience"/><br>
                        			
                        			<!-- Begin Location -->
                        			<div>
                            			<?php if ($errors->first('location') != null) echo "<b class=\"center\">" 
                                            . $errors->first('location') . " </b><br>"; ?>
                        			</div>
                        			<label for="location" class="col-md-4 col-form-label text-md-right">Location</label>
                        			<input type="text" name="location"/><br>
                        		
                        			<!-- Begin Description -->	
                        			<!-- Had to edit the css for this to make the label top-align -->
                        			<div>
                            			<?php if ($errors->first('description') != null) echo "<b class=\"center\">" 
                                            . $errors->first('description') . "</b><br>"; ?>
                        			</div>
                        			<label for="description" class="col-md-4 col-form-label text-md-right align-top">Description</label>
                        			<textarea rows="10" col="20" name="description"></textarea><br><br>	
                        			
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