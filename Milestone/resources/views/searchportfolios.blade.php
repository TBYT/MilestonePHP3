@extends('layouts/app')

<html>
	@section('content')
	<body>
		<div class="container">
        	<div class="row justify-content-center">
            	<div class="col-md-8">
    				<div class="card">
    					<div class="card-header">View Job</div>
    						<div class="card-body">
    							<form action="searchportfolios" method="post"> 
    								{{ csrf_field() }}
    								<label for="pattern">Enter the name of the person you would like to search for</label>
    								<input type="text" name="pattern" id="pattern"/>
    								<input type="submit" value="Search"/>
    							</form>
    								
    								@if(isset($portfolios))
    									<h1>{{ $message }}</h1>
    									@foreach ($portfolios as $id => $portfolio)
    										<h3>Name: {{ $portfolio[0] }}</h3>
    										<h5>Education</h5>
    										@foreach ($portfolio[1]->getEducation() as $education)
    											<a>Start Date: {{ $education['startdate'] }}</a>
    											<a>End Date: {{ $education['enddate'] }}</a>
    											<a>Institution: {{ $education['institution'] }}</a>
    											<a>GPA: {{ $education['gpa'] }}</a>
    										@endforeach
    										<h5>Skills</h5>
    										@foreach ($portfolio[1]->getSkills() as $skill)
    											<a>{{ $skill }}</a>
    										@endforeach
    										<h5>Job History</h5>
    										@foreach ($portfolio[1]->getHistory() as $history)
    											<a>{{ $history }}</a>
    										@endforeach
    									@endforeach
    								@endif
    							</form>
    						</div>
    				</div>
    			</div>
    		</div>
    	</div>
	</body>
	@endsection
</html>