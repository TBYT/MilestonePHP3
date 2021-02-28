<!-- Page to show portfolio search form and results -->

@extends('layouts/app')

<html>
	@section('content')
	<body>
		<div class="container">
        	<div class="row justify-content-center">
            	<div class="col-md-8">
    				<div class="card">
    					<div class="card-header">View Portfolio</div>
    						<div class="card-body" align="center">
    						      <!-- Form to make search -->
    							<form action="searchportfolios" method="post"> 
    								{{ csrf_field() }}
    								<label for="pattern">Enter the name of the user you would like to search for.</label><br/>
    								<input type="text" name="pattern" id="pattern"/>
    								<input type="submit" value="Search" class="btn btn-primary"/>
    							</form>
    							
    								<!-- Display all results if any -->
    								<div align="left">
    								@if(isset($portfolios))
    								
    									<!-- Success/Error message for results -->
    									<h1 class="card border border-secondary">{{ $message }}</h1>
    									
    									<!-- Display each result as list item -->
    									@foreach ($portfolios as $id => $portfolio)
    									
    										<!-- Name -->
    										<h3 class="card-header">Name: {{ $portfolio[0] }}</h3>
    										<div class="card-body border border-secondary">
    										
    										<!-- Begin education -->
    										<h5>Education</h5>
    										<!-- If no educations added -->
    										@if (count($portfolio[1]->getEducation()) == 0)
    											<b>None</b>
    										@endif
    										<!-- Display each education's details -->
    										@foreach ($portfolio[1]->getEducation() as $education)
    											<b>Institution: {{ $education['institution'] }}</b><br/>
    											<a>Start Date: {{ $education['startdate'] }}</a><br/>
    											<a>End Date: {{ $education['enddate'] }}</a><br/>
    											<a>GPA: {{ $education['gpa'] }}</a><br><br>
    										@endforeach
    										
    										<!-- Begin Skills -->
    										<hr><h5>Skills</h5>
    										<!-- If no skills added -->
    										@if (count($portfolio[1]->getSkills()) == 0)
    											<b>None</b>
    										@endif
    										<!-- Display each skill's details -->
    										@foreach ($portfolio[1]->getSkills() as $skill)
    											<a>{{ $skill }}, </a><br>
    										@endforeach
    										
    										<!-- Job History -->
    										<hr><h5>Job History</h5>
    										<!-- If no job history added -->
    										@if (count($portfolio[1]->getHistory()) == 0)
    											<b>None</b>
    										@endif
    										<!-- Display each job history's detailsi -->
    										@foreach ($portfolio[1]->getHistory() as $history)
    											<a>{{ $history }}</a><br/>
    										@endforeach
    										</div>
    									@endforeach
    								@endif
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