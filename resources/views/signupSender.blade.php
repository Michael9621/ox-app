@extends('layouts.app')


@section('content')

    <div class="container" style="height:70vh;">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-lg-6">
                <div class="card-2">
                    <h4>register</h4>
                     <form action="{{ route('registerSender') }}" method="POST" >

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="enter your name" name="name">
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="enter your email address" name="email">
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="enter password" name="password">
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="confrim password" name="password">
                        </div>

                        <button class="btn btn-primary">register</button>

                        

                        @csrf
                     </form>
                </div>
            </div>
        </div>
    </div>

@endsection