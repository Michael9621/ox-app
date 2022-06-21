@extends('layouts.app')

@section('content')

<div class="container">

            <button type="button" tabindex="0" class="btn btn-primary"><a style="color:black;" href="{{route('logout')}}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" >
                @csrf
            </form>     
        </button>
        <p>hello {{$user->name}}</p>
       

        @can('post-photo')
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" id="btn-add">
                add
            </button>
        @endcan
        
        <h1>assigned photos</h1>
       
            <div class="row " id="photos-list" name="photos-list">
            @can('view-photo')
                @if($user->photos->count())
                    @foreach($user->photos as $photo)
                        <div class="col-lg-4 img" id="photo-{{$photo->id}}">
                            <img src="{{asset('./uploads/content/'.$photo->img)}}" alt="">
                        </div>
                    @endforeach
                @else
                    <p>no uploaded photos</p>
                @endif

            @endcan
                @role('Receiver')
                    
                    @foreach($user->mphotos as $photo)
                        <div class="col-lg-4 img" id="photo-{{$photo->id}}">
                            <img src="{{asset('./uploads/content/'.$photo->img)}}" alt="">
                        </div>
                    @endforeach
                @endrole
            </div>
       

        
    </div>

    @can('post-photo')
    <!-- The Modal -->
    <div class="modal fade"  id="linkEditorModal" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title" id="linkEditorModalLabel">Modal Heading</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">

                <form id="modalFormData" enctype="multipart/form-data" name="modalFormData" class="form-horizontal">
                    <div class="form-group">
                        <input type="file" name="photo" id="photo" class="form-control">
                    </div>
                
                    <div class="form-group">
                        <select name="user_id" id="user_id" class="user_photo"></select>
                    </div>

                    <input type="hidden" id="photo_id" name="photo_id" value="0">

                    <button class="btn btn-primary" id="btn-save" value="add">save changes</button>
                    
                </form>
            
            </div>
            
        
        </div>
        </div>
    </div>
    @endcan

@endsection