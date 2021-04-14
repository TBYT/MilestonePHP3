<!-- Page to make new Affinity group -->

@extends('layouts/app')
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
	
	@section('content')
	<body>
    	<div class="container">
        	<div class="row justify-content-center">
            	<div class="col-md-8">
    				<div class="card">
    					<div class="card-header">Add Affinity Group</div>
    
    						<div class="card-body">
    							<!-- Form to initialize each of the fields -->
                        		<form method="post" action="addaffinitygroup">
                        			{{csrf_field()}}
                        			
                        			<!-- Begin Title -->
                        			<label for="name" class="col-md-4 col-form-label text-md-right">Title</label>
                        			<input type="text" name="name" required minlength="4" maxlength="30"/><br>
                        		
                        			<!-- Begin Description -->	
                        			<!-- Had to edit the css for this to make the label top-align -->
                        			<label for="description" class="col-md-4 col-form-label text-md-right align-top">Description</label>
                        			<textarea rows="10" col="20" name="description" required maxlength="240"></textarea><br><br>	
                        			
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