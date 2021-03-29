<html>
    @extends('layouts/app')
    
    <body>
    	@section('content')
    		<div class="row justify-content-center">
                <div class="col-md-8">
                    <div align="center" class="card">
                        <div class="card-header"><h3>Verify Email</h3></div>
        			<h3> Enter Your Code </h3>
        			
        			<form action="verifyuser" method="post">
        				{{csrf_field()}}
        				<!-- Begin State -->
        				<label for="code">6-Digit Code</label>
        				<input type="text" name="code" id="code"/><br>
        				<input type="submit" value="Submit"/>
        			</form>
            		<form action="sendemail" method="get">
            			<label for="email">Resend Email</label>
            			<input type="submit" value="Verify" name="email" id="email"/><br>
           				<hidden name="email" value="{{ session('user')->getEmail() }}"/>
           				<hidden name="name" value="{{ session('user')->getName() }}"/>
           			</form>
        			</div>
				</div>
			</div>
		@endsection
    </body>

</html>
