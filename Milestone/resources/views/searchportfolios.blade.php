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
    							<form action="searchportfolios" method="post"> 
    								{{ csrf_field() }}
    								<label for="pattern">Enter the name of the user you would like to search for.</label><br/>
    								<input type="text" name="pattern" id="pattern"/>
    								<input type="submit" value="Search" class="btn btn-primary"/>
    							</form>
    								<div align="left">
    								@if(isset($portfolios))
    									<h1 class="card border border-secondary">{{ $message }}</h1>
    									@foreach ($portfolios as $id => $portfolio)
    										<h3 class="card-header">Name: {{ $portfolio[0] }}</h3>
    										<div class="card-body border border-secondary">
    										<h5>Education</h5>
    										@foreach ($portfolio[1]->getEducation() as $education)
    											<a>Institution: {{ $education['institution'] }}</a><br/>
    											<a>Start Date: {{ $education['startdate'] }}</a><br/>
    											<a>End Date: {{ $education['enddate'] }}</a><br/>
    											<a>GPA: {{ $education['gpa'] }}</a><hr>
    										@endforeach
    										<h5>Skills</h5>
    										@foreach ($portfolio[1]->getSkills() as $skill)
    											<a>{{ $skill }}, </a>
    										@endforeach
    										<hr><h5>Job History</h5>
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