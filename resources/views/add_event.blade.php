<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="{{ url('assets/library/datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">    
        <!-- Styles -->
        <style>
            .error{ color:red }
        </style>
    </head>
    <body class="antialiased">

        <div class="container">
            <div class="row">    
                <div class="col-12 mt-5">
                    <form method="post" id="eventForm" name="event" action="{{ route('handle-post') }}">  
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />  
                        <input type="hidden" name="id" value="{{ (!empty($eventData)?$eventData->id:'') }}" />  

                        <div class="form-group">
                            <label for="title">Event Title *</label>
                            <input type="text" class="form-control" name="title" value="{{ (!empty($eventData)?$eventData->varTitle:'') }}" id="title" autocomplete="off" placeholder="Enter event title">
                            <span class="error">{{ $errors->first('title') }}</span>
                        </div>
                        <div class="form-group mt-2">
                            <label for="startDate">Start Date*</label>
                            <input type="text" class="form-control" id="startDate" value="{{ (!empty($eventData)?date('d-m-Y',strtotime($eventData->dtStartDate)):'') }}" name="startDate" placeholder="Start Date" autocomplete="off">
                            <span class="error">{{ $errors->first('startDate') }}</span>
                        </div>
                        <div class="form-group mt-2">
                            <label for="endDate">End Date*</label>
                            <input type="text" class="form-control" id="endDate"  name="endDate" value="{{ (!empty($eventData)?date('d-m-Y',strtotime($eventData->dtEndDate)):'') }}" placeholder="End Date" autocomplete="off">
                            <span class="error">{{ $errors->first('endDate') }}</span>
                        </div>
                        <div class="form-group mt-2">
                            <label >Recurrence*</label>
                            @php 
                            $RT = '';
                            $varOccurrence = '';
                            if(!empty($eventData)){
                                if($eventData->varRecurrence == "RT"){
                                    $RT =  'checked';
                                }
                                if(!empty($eventData->varOccurrence)){
                                    $varOccurrence = explode(' ', $eventData->varOccurrence);
                                }
                            }
                            @endphp
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="recurrence" id="recurrence" value="RT" {{ $RT }}>
                                <label class="form-check-label" for="recurrence">Repeat</label>
                            </div>
                            <div class="form-group form-check-inline">
                                <label for="every"></label>
                                <select class="form-control" name="rt_time" id="every">
                                    <option value="every" {{ (isset($varOccurrence[0]) && $varOccurrence[0] == "every"?'selected':'') }}>Every</option>
                                    <option value="every_other" {{ (isset($varOccurrence[0]) && $varOccurrence[0] == "every_other"?'selected':'') }}>Every Other</option>
                                    <option value="every_third" {{ (isset($varOccurrence[0]) && $varOccurrence[0] == "every_third"?'selected':'') }} >Every Third</option>
                                    <option value="every_forth" {{ (isset($varOccurrence[0]) && $varOccurrence[0] == "every_forth"?'selected':'') }}>Every Forth</option>
                                </select>
                            </div>
                            
                            <div class="form-group form-check-inline">
                                    <label for="day"></label>
                                    <select class="form-control" name="rt_day" id="day">
                                        <option value="day" {{ (isset($varOccurrence[1]) && $varOccurrence[1] == "day"?'selected':'') }}>Day</option>
                                        <option value="week" {{ (isset($varOccurrence[1]) && $varOccurrence[1] == "week"?'selected':'') }}>Week</option>
                                        <option value="month" {{ (isset($varOccurrence[1]) && $varOccurrence[1] == "month"?'selected':'') }}>Month</option>
                                        <option value="year" {{ (isset($varOccurrence[1]) && $varOccurrence[1] == "year"?'selected':'') }}>Year</option>
                                    </select>
                            </div>

                            <!-- <div class="form-check form-check-inline">
                                @php 
                                $ROT = '';
                                if(!empty($eventData) && $eventData->varRecurrence == "ROT"){
                                    $ROT =  'checked';       
                                }
                                @endphp
                                <input class="form-check-input" type="radio" name="recurrence" id="recurrence" value="ROT" {{ $ROT }}>
                                <label class="form-check-label" for="recurrence">Repeat on the</label>
                            </div> -->

                            <!-- <div class="form-group form-check-inline">
                                    <label for="first"></label>
                                    <select class="form-control" name="rot_day" id="day">
                                        <option value="first">First</option>
                                        <option value="second">Second</option>
                                        <option value="third">Third</option>
                                        <option value="forth">Forth</option>
                                    </select>
                            </div>
                            <div class="form-group form-check-inline">
                                    <label for="week"></label>
                                    <select class="form-control" name="rot_week" id="week">
                                        <option value="Sunday">Sunday</option>
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                        <option value="Saturday">Saturday</option>
                                    </select>
                            </div>
                            <div class="form-group form-check-inline">
                                <label for="month">of the</label>
                            </div>
                            <div class="form-group form-check-inline">
                                    <select class="form-control" name="rot_month" id="month">
                                        <option value="month">Month</option>
                                        <option value="3 Months">3 Months</option>
                                        <option value="4 Month">4 Month</option>
                                        <option value="6 Month">6 Month</option>
                                        <option value="year">Year</option>
                                    </select>
                            </div> -->
                        </div>
                        <span class="error">{{ $errors->first('recurrence') }}</span>
                        <div class="form-group ">
                            <button type="submit" class="btn btn-primary mt-2">Submit</button>
                        </div>    

                    </form>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="{{ url('assets/library/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
        
        <script>
            $('#startDate').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true
            });
            $('#endDate').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true
            });
        </script>
        <script>
             $("#eventForm").validate({
                rules: {
                    title:{
                        required: true
                    },
                    startDate: {
                        required: true
                    },
                    endDate: {
                        required: true
                    },
                    recurrence:{
                        required: true
                    }
                },
                // Specify validation error messages
                messages: {
                    title: "Event title is required",
                    startDate: "Please select start date",
                    endDate: {
                        required: "Please select end date"
                    },
                    recurrence:"Please select recurrence type"
                },
                errorPlacement: function (error, element) {
                    if (element.attr("type") == "radio") {
                        error.insertAfter($(element).parent('div').parent('.form-group'));
                    }else{
                        error.insertAfter($(element));
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        </script>

    </body>
    
</html>
