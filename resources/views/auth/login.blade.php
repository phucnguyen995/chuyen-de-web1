@extends('master')
@section('title','Login')
@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-push-3">
                    <h2>Log in to your account</h2>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if ($message = Session::get('fail'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                            <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form role="form" action="{{url('checkLogin')}}" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label class="control-label">Email Address:</label>
                                    <input type="email" required name="email" class="form-control" placeholder="Enter your email address" value="{{ old('email') }}">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Password:</label>
                                    <input type="password" required name="password" class="form-control" placeholder="Enter your password">
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Log In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
      @endsection