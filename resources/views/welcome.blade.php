@extends('layouts.app')

@section('content')

<div class="container">

            

        <div class="d-flex justify-content-between">
            
            @can('post-photo')
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" id="btn-add">
                    upload
                </button>
            @endcan

        
                <p>Welcome {{$user->name}}</p>

                <button type="button" tabindex="0" class="btn btn-primary"><a style="color:black;" href="{{route('logout')}}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" >
                        @csrf
                    </form>     
                </button>
            
            
            
        </div>
        @role('Receiver')
            <div>
            <h5 class="receiver-header">assigned photos</h5>
            </div>
        @endrole
            <div class="row " id="photos-list" name="photos-list">
            @role('Sender')
                @if($user->photos->count())
                    @foreach($user->photos()->latest()->get() as $photo)
                        <div class="col-lg-4 img" id="photo-{{$photo->id}}">
                            <div class="section">
                                <img src="{{asset('./uploads/content/'.$photo->img)}}" alt="">
                                
                                <div class="d-flex justify-content-between">
                                  
                                    @foreach($photo->musers as $user)
                                        @if($user->status->count() > 0)
                                            @if( $user->status()->where('type',0)->count() > 0 && 
                                                $user->status()->where('type',1)->count() > 0 
                                            )
                                                @if($user->status()->where('type',0)->orderBy('created_at', 'DESC')->first()->created_at > $photo->created_at
                                                    && $user->status()->where('type',1)->orderBy('created_at', 'DESC')->first()->created_at > $photo->created_at
                                                )
                                                    <span class="badge badge-pill badge-success">viewed</span>
                                                @elseif($user->status()->where('type',0)->orderBy('created_at', 'DESC')->first()->created_at < $photo->created_at 
                                                    && $user->status()->where('type',1)->orderBy('created_at', 'DESC')->first()->created_at <
                                                    $user->status()->where('type',0)->orderBy('created_at', 'DESC')->first()->created_at
                                                )
                                                    <span class="badge badge-pill badge-success">viewed</span>
                                                @elseif($user->status()->where('type',0)->orderBy('created_at', 'DESC')->first()->created_at < $photo->created_at 
                                                    && $user->status()->where('type',1)->orderBy('created_at', 'DESC')->first()->created_at >
                                                    $photo->created_at
                                                )
                                                    <span class="badge badge-pill badge-success">viewed</span>
                                                @elseif($user->status()->where('type',0)->orderBy('created_at', 'DESC')->first()->created_at > $photo->created_at 
                                                    && $user->status()->where('type',1)->orderBy('created_at', 'DESC')->first()->created_at <
                                                    $user->status()->where('type',0)->orderBy('created_at', 'DESC')->first()->created_at
                                                )
                                                    <span class="badge badge-pill badge-success">viewed</span>
                                          
                                                @endif
                                    
                                            @else
                                              
                                                @if( $user->status()->where('type',0)->count() > 0)

                                                        @if($user->status()->where('type',0)->orderBy('created_at', 'DESC')->first()->created_at < $photo->created_at
                                                        && $user->status()->where('type',1)->count() == 0)
                                                                <span class="badge badge-pill badge-success">viewed</span>

                                                        @elseif($user->status()->where('type',0)->orderBy('created_at', 'DESC')->first()->created_at  > $photo->created_at
                                                        && $user->status()->where('type',1)->count() == 0)
                                                                <span class="badge badge-pill badge-success">viewed</span>
                                                        @else
                                                            <span class="badge badge-pill badge-danger">not viewed</span>
                                                        @endif
                                                @else
                                                    <span class="badge badge-pill badge-danger">not viewed</span>
                                                @endif

                                            @endif
                                        @else
                                            <span class="badge badge-pill badge-danger">not viewed</span>
                                        @endif
                                        <p>Assigned user : {{$user->name}}</p>
                                    @endforeach
                                </div>

                                <p><b>Date posted : </b> {{$photo->created_at->toFormattedDateString()}}</p>
                            </div>
                            
                        </div>
                    @endforeach
                @else
                    <p>no uploaded photos</p>
                @endif

            @endrole

            @role('Receiver')
                   @if($user->mphotos()->count())
                   @foreach($user->mphotos()->latest()->get() as $photo)
                   
                       <div class="col-lg-4 img" id="photo-{{$photo->id}}">
                           <div>
                               <img src="{{asset('./uploads/content/'.$photo->img)}}" alt="">
                               <div>
                                   <a href="{{route('download-photo', ['photo' => $photo->id])}}">Download image</a>
                                   <p><b>Date posted : </b> {{$photo->created_at->toFormattedDateString()}}</p>
                               </div>
                           </div>
                       </div>
                   
                   
                   @endforeach
                   @else
                        <p>no photos assigned yet</p>
                   @endif


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
                        <span class="text-danger p-1" id="photo_error"></span>
                    </div>
                
                    <div class="form-group">
                        <select name="user_id" id="user_id" class="user_photo"></select>
                        <span class="text-danger p-1" id="user_id_error"></span>
                    </div>

                    <input type="hidden" id="photo_id" name="photo_id" value="0">

                    <button class="btn btn-primary" id="btn-save" value="add">Upload photo</button>
                    
                </form>
            
            </div>
            
        
        </div>
        </div>
    </div>
    @endcan

@endsection