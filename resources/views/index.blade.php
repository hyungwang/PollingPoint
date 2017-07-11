<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="{{asset('packages/fa/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('packages/materialize/css/materialize.css')}}" >

</head>
<body class="">
  <div id="start">
    	<div class="row">
    		<div class="col m12">
    			<div class="card blue-grey lighten-1">
  				<div class="card-content white-text">
  					<h3 class="card-title">
  						POLLING POINT
  					</h3>
  					<p>welcome to polling point a site for survey currently under development
  					Creator:HYUNG</p>
            <br>
            @if(Auth::check())
            <p class="blue-text">You are Logged In as {{ucfirst(Auth::user()->name)}}</p>
            @endif
  				</div>
  				<div class="card-action">
                    @if(!Auth::check())
  					<a href="#login" class="modal-trigger">Log in</a>
  					<a href="#register" class="modal-trigger">Register</a>
                    @else
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    @endif
  				</div>
    			</div>
    		</div>
    	</div>
      @if(Session::has('message'))
          <p class="card green lighten-4">{{Session::get('message')}}</p>
      @endif

      @if(Session::has('error'))
        <p class="card red lighten-4">{{Session::get('error')}}</p>
      @endif

      @if(count($errors)>0)
        <ul>
          @foreach($errors->all() as $error)
            <li class="card red"><span class="fa fa-exclamation- circle"> </span> {{$error}}</li>
          @endforeach
        </ul>
       @endif

      <!-- REGISTER AND LOGIN MODAL LIES HERE-->
      <div id="login" class="modal">
        <div class="modal-content">
            <form action="{{route('login')}}" method="POST">
                {{csrf_field()}}
              <div class="input-field col">
                <label >Email</label>
                <input class="validate" type="text" name="email" required="required" >
              </div>
              <div class="input-field col">
                <label for="password">Password</label>
                <input class="validate" type="password" name="password" required="required">
              </div>
                <input type="submit" value="LOGIN" class="btn waves-effect waves-ripple">

            </form>
        </div>
      </div>

      <div id="register" class="modal">
        <div class="modal-content">
        <form action="{{route('register')}}" method="POST">
            {{csrf_field()}}
          <div class="input-field col">
            <label for="name">Name</label>
            <input class="validate" type="text" name="name" required>
          </div>
          <div class="input-field col">
            <label for="email" >E-mail</label>
            <input class="validate" type="email" name="email" required>
          </div>
          <div class="input-field col">
            <label for="password">Password</label>
            <input class="validate" type="password" name="password" required>
          </div>
          <div class="input-field col">
            <label for="password_confirmation">Confirm password</label>
            <input class="validate" type="password" name="password_confirmation" required>
          </div>
            <input type="submit" value="Submit" class="btn waves-effect waves-light">
        </form>
        </div>
      </div>

      <!-- rEGISTER AND LOGIN MODAL SLEEPS HERE -->


  	<ul class="collapsible popout" data-collapsible="expandable">
  		<li>

  			<div class="collapsible-header">Create Poll</div>
        @if(Auth::check())
  			<div class="collapsible-body ">
  				<form class="container" action="{{action('SiteController@pollCreate')}}" method="POST">
                    {{csrf_field()}}
            <div class="input-field col s8">
  				  <label for="title">Title</label>
                  <input class="validate"  type="text" name="title" id="title" v-model="title" required>
            </div>


            
                    <input class="validate" type="hidden" v-bind:value="option" v-for="option in options" name="options[][name]">

  					<ul class="collection" v-if="available">
  						<li class="collection-item" v-for="option in options">@{{option}}</li>

  					</ul>

                    <div class="input-field col s5">

                        <select name="expire" class="browser-default" required>
                            <option value="" disabled selected>Choose Poll`s number of days:</option>
                            @foreach(range(1,10) as $i)
                            <option value="{{$i}}">{{$i}}</option> days
                            @endforeach
                        </select>

                    </div>
  					<button class="btn waves-effect waves-light  modal-trigger" v-bind:class="{'disabled':btndisabled}" id="btnadd" href="#create" v-bind:disabled="btndisabled">Add Votable Option</button>
                    <button type="submit" class="btn">Save</button>

  				</form>
  			</div>
        @else
        <div class="collapsible-body">
          You have to be logged in to create a poll.
        </div>
        @endif
  		</li>

      <!-- start of add new option modal-->
      <div id="create" class="modal">
        <div class="modal-content">
            <span class="modal-close fa fa-close"></span>
            <div class="input-field col">
            <label for="create">New Option</label>
            <input class="validate" v-model="new" type="text" name="create">
        </div>
          <button class="btn" v-on:click="create()">Add</button>
        </div>
      </div>
        <!-- end of add new option modal-->

  		<li>
  			<div class="collapsible-header"><span class="badge" style="padding-right:2% "> Latest </span>Ongoing Polls</div>
  			<div class="collapsible-body">

                <ul class="container">
                    @foreach($ongoing as $poll)
                        <li class="col s6 offset-s3">
                            <h5>{{$poll->title}}</h5>

                            <form action="{{action('SiteController@vote')}}"  method="POST">
                                    {{csrf_field()}}
                            @foreach($poll->options as $opt)
                                        <input class="validate" type="radio" name="vote" v-model="opt"value="{{$opt->id}}" id="r{{$opt->id}}"> <label for="r{{$opt->id}}">{{$opt->name}} {{$opt->votes}}</label><br>
                                @endforeach

                                    @if(Cookie::has('voted') && array_key_exists($poll->id, Cookie::get('voted')))
                                        <h6>
                                            You voted {{Cookie::get('voted')[$poll->id]}}
                                        </h6>


                                @else
                                <input type="submit" class="btn" value="vote">
                                @endif

                            </form><hr>

                        </li>
                    @endforeach
                    <div class="row">
                    {{$ongoing->links()}}
                    </div>
                </ul>
  			</div>
  		</li>

  		<li>
  			<div class="collapsible-header"><span class="badge" style="padding-right:2% ">Latest</span>Completed Polls </div>
  			<div class="collapsible-body">
                <ul class="container">
                    @foreach($completed as $poll)
                        <li class="col s6 offset-s3">
                            <h6>{{$poll->title}}</h6>

                            <form action=""  >

                                @foreach($poll->options as $opt)
                                    <input class="validate" type="radio" name="vote" value="{{$opt->id}}" id="r{{$opt->id}}"> <label for="r{{$opt->id}}">{{$opt->name}} {{$opt->votes}}</label><br>
                                @endforeach

                            </form><hr>

                        </li>
                    @endforeach
                    <div class="row">
                    {{$completed->links()}}
                    </div>
                </ul>
  			</div>
  		</li>
    </ul>
          </ul>
  </div>


        </div>
      </form>
    </div>
  </div>





  <script src="{{asset('js/jquery.min.js')}}"></script>
  <script src="{{asset('packages/materialize/js/materialize.min.js')}}"></script>
  <script>
    $(document).ready(function(){
      $('.modal-trigger').leanModal();
      $('select').material_select();
      
    });

  </script>
	<script src="{{asset('js/vue.js')}}"></script>
	<script src="{{asset('js/scriptvue.js')}}"></script>
</body>
</html>
