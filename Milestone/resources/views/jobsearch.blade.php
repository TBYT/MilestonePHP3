<!-- Page to search jobs -->

@extends('layouts/app')
	<style>
	   .card 
	   {
	       left:7%;
	       width:1700px;
	   }
	   .searchFields
	   {
	       size:20;
	       margin-left:25px;
	       margin-right:25px;
	   }
	   .search-field-label
	   {
	       width: 184px;
	       margin-left:25px;
	       margin-right:25px;
	       vertical-align:top;
	       text-align:center;
	   }
	   .container
	   {
	       max-width:1700px;
	   }
	   .field-title
	   {
	       position:relative;
	       left:6%;
	   }
	   .center
	   {
	       position:relative;
	       left:14%;
	       width:200px;
	   }   
	</style>
	@section('content')
    	<div class="card">
    		<div class="card-header">Job Search</div>
        		<div class="card-body">
        			@if ($errors->any())
        				<h1 align="center">You Must Enter At Least One Field</h1>
        			@endif
        			
        			<form action="searchjobs" method="post">
        				{{ csrf_field() }}
						
						<!-- Database will query for jobs with similar field values to the entered val -->
						<div class="field-title">
							<label for="title" class="search-field-label">Title</label>
    						<label for="company" class="search-field-label">Company</label>
    						<label for="salary" class="search-field-label">Salary ($)</label>
    						<label for="field" class="search-field-label">Field</label>
    						<label for="experience" class="search-field-label">Experience</label>
    						<label for="location" class="search-field-label">Location</label><br>
    						<input type="text" name="title" id="title" class="searchFields"/>
    						<input type="text" name="company" id="company" class="searchFields"/>
    						<input type="number" name="salary" id="salary" class="searchFields"/>
    						<input type="text" name="field" id="field" class="searchFields"/>
    						<input type="text" name="experience" id="experience" class="searchFields"/>
    						<input type="text" name="location" id="location" class="searchFields"/><br>
    					</div>
        				<br><br>
        							
        				<!-- Submit button -->
        				<div class="col-md-8 offset-md-4">
                            <input type="submit" value="Search" class="btn btn-primary center"/>
                        </div>
        				</form>
        						
        				@if (session('message'))
                        	<h1 align="center"> {{ session('message') }} </h1>
                    			<ul>
                    				<!-- Each job in the list of results -->
                    				<!-- TODO: need an empty list error page -->
                        			@foreach (session('jobs') as $id => $job)
                        			<li>
                        				
                       				<!-- Main title: job title, subheading: company -->
                       				<h2>
                       					Title: {{ $job->getTitle() }}
                       				</h2>
                       				<h5>Company: {{$job->getCompany() }}</h5>
                       				<!-- Button to view full job details -->
                       					<form action="viewjob" method="post">
                       						{{csrf_field()}}
                       						<input type="hidden" name="id" value="{{ $id }}"/>
                       						<input type="submit" value="View"/>
                       					</form>
            	       				@endforeach
                   				</ul>
                   			<form action="jobsearch" method="get">
                   				<input type="submit" value="Clear Search"/>
                   			</form>
               			@endif
        	</div>
		</div>
	@endsection
	