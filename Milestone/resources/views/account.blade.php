<!-- Page to display user account -->

<html>

<!-- CSS for this file (Should maybe be put in layouts folder?) -->
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
                <div class="card-header"><h3>Hello, {{ session()->get('user')->getName() }}</h3></div>
			<h3> Account Details </h3>
			@if(isset($message))
			<h3> {{$message}} </h3>
			@endif
			
			<form action="editUser" method="post">
			{{csrf_field()}}
			
				<!-- Begin Name -->
				<label for="name">Full Name:</label>
				<input type="text" value="{{ $user->getName() }}" name="name" id="name" required/><br>
				
				<!-- Begin Email -->
				<label for="email">Email:</label>
				<input type="email" value="{{ $user->getEmail() }}" name="email" id="email" required/><br>
				
				<!-- Begin Password (Change this??) -->
				<label for="password">Password:</label>
				<input type="text" value="{{ $user->getPassword() }}" name="password" id="password" required/><br>
				
				<!-- Begin Website Link -->
				<label for="website">Website Link:</label>
				<input type="url" value="{{ $user->getWebLink() }}" name="website" id="website"/><br>
				
				<!-- Begin City -->
				<label for="city">City:</label>
				<input type="text" value="{{ $user->getCity() }}" name="city" id="city"/><br>
				
				<!-- Begin State -->
				<label for="state">State:</label>
				<input type="text" value="{{ $user->getState() }}" name="state" id="state"/><br>
				
				<br><br><br>
				<input type="submit" value="Save Changes"/>
			</form>
			@if(!$user->getIsVerified())
    			<form action="sendemail" method="get">
    				{{csrf_field()}}
    				<label for="email">Verify Account</label>
    				<input type="submit" value="Verify" name="email" id="email"/><br>
    				<hidden name="email" value="{{ $user->getEmail() }}"/>
    				<hidden name="name" value="{{ $user->getName() }}"/>
    			</form>
    		@endif
			</div>
			</div>
		</div>
		@endsection
	</body>
</html>