@extends('master')
@section('title','Register')
@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-push-3">
                    <h2>Join as a Wordskills Travel Member</h2>
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
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form role="form" method="POST" action="{{url('/auth/register')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label class="control-label">Email Address:</label>
                                    <input type="email" class="form-control" placeholder="Enter your email address" name="email" value="{{ old('email') }}">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Password:</label>
                                    <input type="password" name="password" class="form-control" placeholder="Enter your password">
                                </div>

                                 <div class="form-group">
                                    <label class="control-label">Confirm Password:</label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Enter confirm password">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Name:</label>
                                    <input type="text" name="first_name" class="form-control" placeholder="Enter your name" value="{{ old('first_name') }}">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Phone Number:</label>
                                    <input type="tel" name="phone" class="form-control" placeholder="Enter your phone number">
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @endsection