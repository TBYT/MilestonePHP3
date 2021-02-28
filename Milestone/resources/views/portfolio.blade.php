<!-- Page to allow the user to see and update their portfolio -->

<html>

<!-- CSS used for page styling
    Needs to be put in the css page -->
<!-- TODO: can't get the borders for the subset input fields to work -->
<style>
     .center 
     { 
         left: 45%; 
         color: green; 
     } 
     .dropdownbtn
     { 
         width: 40%;
         background-color:aquamarine;
     } 
     .dropdown-item 
     { 
         width: 30%; 
     }
     .form-input
     {
         border-style: solid; 
         border-width: 5px;
         background-color:teal;
     }
</style>

	@extends('layouts/app')
	<head>
		<title>Portfolio</title>
	</head>
	
	<body>
		
		@section('content')
		<div class="row justify-content-center">
        	<div class="col-md-8">
            	<div align="center" class="card">
                	<div class="card-header"><h3>Hello, {{ session()->get('user')->getName() }}</h3></div>
                		@if (isset($message))
                		<h1>{{ $message }}</h1>
                		@endif
                		<p> <?php if ($errors->any())
                		  {
                		      echo $errors->all();
                		  }
                		?>
						<h3> Portfolio Details </h3>
						
						<!-- Main section of the page is a form for editing the portfolio -->
						<form action="editportfolio" method="post" id="edit">
							{{ csrf_field() }}
							<input type="hidden" value="{{ $portfolioID }}" name="portfolioID"/>
							
							<!-- Begin education dropdown -->
							<div class="dropdown" id="education_dropdown">
								<button data-toggle="dropdown" aria-haspopup="true" class="dropdownbtn" 
										aria-expanded="false" id="education_dropwdown">
										Education
								</button>
    							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    							
    								<!-- Each property will have an index range
    								        100-199 is for education -->
    								<?php $index = 100; ?>
    								
    								<!-- For each education, Show Data -->
        							@foreach ($portfolio->getEducation() as $data)
        							
                						<div class="dropdown" id="{{ $index }}">
                						
                							<!-- Initial display is expand button with insitution name -->
               								<button type="button" action="expandItem({{ $index }})" name="expand_button" class="dropdown-item"
               										onclick="expandEducation({{ $index }})" style="display:block" id="{{ $index }},button">
               										{{ $data['institution'] }}
               								</button>
               								
               								<!-- Secondary display, input field for the each property -->
                   							<div id="{{ $index }},main" class="dropdown-item" style="display:none">
                   								
                   								<!-- Institution -->
                           						<input type="text" class="dropdown-item form-input" name="{{ $index }},institution"
                           								value="{{ $data['institution'] }}" style="border-style: solid; 
         												border-width: 2px;"></input>
                           								
                           						<!-- Start Date -->
                           						<input type="date" class="dropdown-item" name="{{ $index }},startdate"
                           								value="{{ $data['startdate'] }}" style="border-style: solid; 
         												border-width: 2px;"></input>
                           								
                           						<!-- End Date -->
                           						<input type="date" class="dropdown-item" name="{{ $index }},enddate"
                           								value="{{ $data['enddate'] }}" style="border-style: solid; 
         												border-width: 2px;"></input>
                           							
                           						<!-- GPA -->
                           						<input type="number" class="dropdown-item" name="{{ $index }},gpa" value="{{ $data['gpa'] }}" 
                           								style="border-style: solid; border-width: 2px;" placeholder="1.0" step="0.01" 
                           								min="0" max="5"></input>
                           								
                           						<!-- Button to Hide details and go back to initial display -->
                        						<button type="button" onclick="expandEducation({{ $index }})">
                        							Hide Details
                        						</button>
                       						   <!-- Java Script Button for deleting the education, increment the index-->
                       							<button type="button" value="Delete" onclick="deleteItem({{ $index ++ }})">
                       								Delete
                       							</button>
                   							</div>
               							</div>
   									@endforeach
   								</div>
							</div>
							<br>
							<!-- Input field for the form to add a new education -->
							<input type="submit" value="Add New" form="addEducation"/>
							<br><br>
				
							<!-- Skills Section -->
							
							<!-- Start with the dropdown -->
							<div class="dropdown">
								<button data-toggle="dropdown" class="dropdownbtn" aria-haspopup="true" aria-expanded="false">
									Skills
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								
									<!-- Indexes 200-299 are for skills -->
									<?php $index = 200; ?>
									
									<!-- For each skill, show data -->
    								@foreach($portfolio->getSkills() as $data)
    									<div id="{{ $index }}">
    										<!-- Display the item details input -->
        									<input type="text" class="dropdown-item" value="{{ $data }}" 
        										name="{{ $index }}" required style="border-style: solid; 
         										border-width: 2px;"/><br>
        									
        									<!-- Button to delete a skill -->
           									<button type="button" value="Delete" onClick="deleteItem({{ $index ++ }})">
           										Delete
           									</button>
    									</div>
    								@endforeach
								</div>	
							</div>
							<br>
							<!-- Submit button for the form to add a new skill -->
							<input type="submit" value="Add New" form="addskill"/>
           					<br><br>
				
							<!-- Job History Section -->
							
							<!-- Dropdown -->
							<div class="dropdown">
            					<button data-toggle="dropdown" class="dropdownbtn" aria-haspopup="true" aria-expanded="false">
            						Job History
            					</button>
            					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            					
            						<!-- Indexes 300+ are for job histories -->
                					<?php $index = 300; ?>
                					
                					<!-- For each history, display data -->
                    				@foreach($portfolio->getHistory() as $data)
                    					<div id="{{ $index }}">
                    						<!-- Display the item details input -->
                        					<input type="text" class="dropdown-item" value="{{ $data }}" 
                        						name="{{ $index }}" style="border-style: solid; 
         										border-width: 2px;" required/><br>
                        					
                        					<!-- Button to delete a history-->
                           					<button type="button" value="Delete" onClick="deleteItem({{ $index ++ }})">
                           						Delete
                           					</button>
                    					</div>
                    				@endforeach
            					</div>	
							</div>
							<br>
							
							<!-- Submit button for the form to add a new history -->
							<input type="submit" value="Add New" form="addhistory"/>
							<br><br>
				
							<br><br><br>
							
							<!-- Submit button to save all data -->
							<input form="edit" type="submit" class="btn-primary center" Value="Save Changes"/>
						</form>
			
						<!-- Form to add education, submit button nested in the main form -->
            			<form action="addeducation" method="get" id="addEducation">
            				{{ csrf_field() }}
            				<!-- Pass portfolioID -->
            				<input type="hidden" name="portfolioID" value="{{ $portfolioID }}"/>
            			</form>
			
						<!-- Form to add job history, submit button nested in the main form -->
            			<form action=addhistory method="get" id="addhistory">
            				{{ csrf_field() }}
            			     <!-- Pass portfolioID -->
            			     <input type="hidden" name="portfolioID" value="{{ $portfolioID }}"/>
            			</form>
			
						<!-- Form to add skill, submit button nested in the main form -->
						<form action="addskill" method="get" id="addskill">
							{{ csrf_field() }}
							<!-- Pass portfolioID -->
							<input type="hidden" name="portfolioID" value="{{ $portfolioID }}"/>
						</form>
						
						</div>
					</div>
				</div>
	
	<!-- Java script functions -->
	<script type="text/javascript">
	
		//Function to delete education, skills, or history
		function deleteItem(id)
		{
			//Find the item by the id passed and delete it
    		var item = document.getElementById(id);
   			item.remove();
		}
			
		function expandEducation(item)
		{
			//get the elements of the primary and secondary display
    		var id = String(item);
       		var main = document.getElementById(id.concat(',main'));
       		var button = document.getElementById(id.concat(',button'));
        			
       		//If the primary display is not showing, show it and hide the secondary
       		if (main.style.display == "none")
       		{
          		main.style.display = "block";
         		button.style.display = "none";
           	}
           		
       		//Else, hide the primary display and show the secondary display
       		else 
   			{
       			main.style.display = "none";
       			button.style.display = "block";
       		}
		}
		
	</script>
		
	@endsection
	</body>
</html>