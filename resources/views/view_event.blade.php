<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <!-- Styles -->
    </head>
    <body class="antialiased">
        <div class="container">
            <div class="row"> 
                
                <div class="col-12 mt-5">
                
                <a href="{{ route('event-list') }}" class="btn btn-primary mt-2 ">Back to List</a><br/>
                <br/>
                <label><b>Event Title:</b> {{ $eventData->varTitle }}</label>    
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date</th>
                        <th scope="col">Day Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($eventDates->count() > 0)
                            @foreach($eventDates as $key => $val)
                                <tr>
                                    <th scope="row">{{ $key + 1  }}</th>
                                    <td>{{ date('Y-m-d' , strtotime($val->dtDates))  }}</td>
                                    <td>{{ date('l' , strtotime($val->dtDates))  }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <th scope="row" colspan="5">No dates are avaialble</th>
                            </tr>
                        @endif        
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
    
</html>
