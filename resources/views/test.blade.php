<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>right</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
           

          
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
          name : {{$user->name}}

          <h4>user's photos</h4>
          
        
          @if($user->photos->count() > 0)
            @foreach($user->photos as $photo)
               <p> {{$photo->img}} </p>
               @foreach($photo->musers as $user)
                 <p>  assigned: {{$user->name}} - viewed - {{$user->pivot->viewed}}</p>
               @endforeach
            @endforeach
          @else
            <p>nothing</p>
          @endif

          <h4>assigned photos</h4>
            @dd([
                $user->name    
            ])
            @if($user->mphotos->count() > 0)
          
            @foreach($user->mphotos as $photo)
                <p>name: {{$photo->img}}</p>
                <p>user: {{$photo->user->name}}</p>
            @endforeach
            @else
                <p>no photos</p>
            @endif

        </div>
    </body>
</html>
