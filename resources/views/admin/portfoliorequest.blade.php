<!-- This page has not yet been implemented -->

@extends('layouts/app')

@section('content')
<html>
    <body>
    <div class="container">
    	<div class="row justify-content-center">
        	<div class="col-md-8">
				<div class="card">
					<div class="card-header">Review Request</div>
						<div class="card-body">
                        	<h3>{{ $name }}</h3>
                        	<ul>
                        		<lh>Skills</lh>
                        		@foreach ($portfolio->getSkills() as $skill)
                        		<li>{{ $skill }}
                        		@endforeach
                        	</ul>
                        	<ul>
                        		<lh>Skills</lh>
                        		@foreach ($portfolio->getHistory() as $history)
                        		<li>{{ $history }}
                        		@endforeach
                        	</ul>
                        	<ul>
                        		<lh>Skills</lh>
                        		@foreach ($portfolio->getEducation() as $education)
                        		<li>{{ $education }}
                        		@endforeach
                        	</ul>
                        	
                        	<form action="approverequest" method="post">
                        		<label for="submit">Click Here to approve this request</label><br>
                        		<input type="submit" id="submit" value="Approve"/>
                        		<input type="hidden" name="id" value="{{ $id }}"/>
                        	</form>
                        	<form action="denyrequest" method="post">
                        		<label for="submit">Click Here to deny this request</label><br>
                        		<input type="submit" id="submit" value="Deny"/>
                        		<input type="hidden" name="id" value="{{ $id }}"/>
                        	</form>
                        </div>
                  	</div>
              	</div>
			</div>
		</div>
    </body>
</html>
@endsection