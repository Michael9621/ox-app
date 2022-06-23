@extends('layouts.app')


@section('content')

    <div class="container" style="height:70vh;">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-lg-6">
                <div class="card-2">
                    <h4>login</h4>
                 
                     <form action="{{ route('auth') }}" method="POST" >
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="email" name="email">
                        </div>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="password" name="password">
                        </div>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <button class="btn btn-primary">login</button>

                        <p> Don't have an account, <a href="{{route('signup')}}">sign up here</a> </p>

                        @csrf
                     </form>
                </div>
            </div>
        </div>
    </div>

@endsection