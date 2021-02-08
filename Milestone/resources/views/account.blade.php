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
		<title>Account</title>
	</head>
	
	<body>
		
		@section('content')
		<div class="row justify-content-center">
        <div class="col-md-8">
            <div align="center" class="card">
                <div class="card-header"><h3>Hello, {{ $user->getName() }}</h3></div>
			<h3> Account Details </h3>
			
			<form action="editUser" method="post">
			{{csrf_field()}}
				<label for="name">Full Name:</label>
				<input type="text" value="{{ $user->getName() }}" name="name" id="name"/><br>
				<label for="email">Email:</label>
				<input type="text" value="{{ $user->getEmail() }}" name="email" id="email"/><br>
				<label for="password">Password:</label>
				<input type="text" value="{{ $user->getPassword() }}" name="password" id="password"/><br>
				<!-- <label for="field">Professsional Field:</label>
				<a type="text" value="{{ $user->getField() }}" name="field" id="field"/><br> -->
				<label for="website">Website Link:</label>
				<input type="text" value="{{ $user->getWebLink() }}" name="website" id="website"/><br>
				<label for="city">City:</label>
				<input type="text" value="{{ $user->getCity() }}" name="city" id="city"/><br>
				<label for="state">State:</label>
				<input type="text" value="{{ $user->getState() }}" name="state" id="state"/><br>
				
				<br><br><br>
				<input type="submit" value="Save Changes"/>
			</form>
			</div>
			</div>
		</div>
		@endsection
	</body>
</html>