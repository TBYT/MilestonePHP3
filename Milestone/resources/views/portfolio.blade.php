<html>

<style>
    .center
    {
        left: 45%;
        color: green;
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
			<h3> Portfolio Details </h3>
			
			<form action="editPortfolio" method="post">
			{{csrf_field()}}
				@foreach ($portfolio->getEducation() as $data)
				<label for="institution">Institution</label>
				<input type="text" value="{{ $data['institution'] }}" name="institution" id="institution" required/><br>
				<label for="startdate">Start Date:</label>
				<input type="text" value="{{ $data['startdate'] }}" name="startdate" id="startdate" required/><br>
				<label for="enddate">End Date:</label>
				<input type="text" value="{{ $data['enddate'] }}" name="enddate" id="enddate" required/><br>
				<label for="gpa">GPA:</label>
				<input type="number" value="{{ $data['gpa'] }}" name="gpa" id="gpa" required/><br>
				@endforeach
				<label for="skills">Skills:</label>
				@foreach($portfolio->getSkills() as $data)
				<input type="text" value="{{ $data }}" name="skills" id="skills" required/><br>
				@endforeach
				<label for="history">Job History:</label>
				@foreach($portfolio->getHistory() as $data)
				<input type="text" value="{{ $data }}" name="history" id="history" required/><br>
				@endforeach
				<br><br><br>
				<input type="submit" value="Save Changes"/>
			</form>
			</div>
			</div>
		</div>
		@endsection
	</body>
</html>