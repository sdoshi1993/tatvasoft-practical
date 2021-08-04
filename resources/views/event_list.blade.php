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
                <a href="{{ route('add-event') }}" class="btn btn-primary mt-2 ">Add Event</a>
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Event Title</th>
                        <th scope="col">Dates</th>
                        <th scope="col">Occurrence</th>
                        <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($eventObj->count() > 0)
                            @foreach($eventObj as $key => $val)
                                <tr>
                                    <th scope="row">{{ $key + 1  }}</th>
                                    <td>{{ $val->varTitle  }}</td>
                                    <td>{{ date('d-m-Y' ,strtotime($val->dtStartDate)) }} to {{ date('d-m-Y' ,strtotime($val->dtEndDate)) }}</td>
                                    <td>{{ str_replace('_',' ',$val->varOccurrence)  }}</td>
                                    <td>
                                        <a href="{{ route('view-event', $val->id) }}" class="btn btn-primary mt-2 ">View</a>
                                        <a href="{{ route('edit-event', $val->id) }}" class="btn btn-primary mt-2 ">Edit</a>
                                        <a href="{{ route('delete-event', $val->id) }}" class="btn btn-primary mt-2 ">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <th scope="row" colspan="5">No events are avaialble</th>
                            </tr>
                        @endif        
                    </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {!! $eventObj->links() !!}
                    </div>    
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
    
</html>
