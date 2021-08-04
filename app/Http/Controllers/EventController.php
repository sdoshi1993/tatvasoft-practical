<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventDates;



class EventController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request) {
        //
    }

    public function index() {

        $eventObj = Event::paginate(10);
        return view('event_list', ['eventObj' => $eventObj]);
    }

    public function viewEvent($id = false) {
        
        $eventData = array();
        $eventDates = array();
        if($id){
            $eventData = Event::where('id',$id)->first();
            $eventDates = EventDates::where('intFkEventId', $id)->get();
        }
        return view('view_event', compact('eventData','eventDates'));
    }

    public function addEvents($id = false) {
        $eventData = array();
        if($id){
            $eventData = Event::where('id',$id)->first();
        }
        return view('add_event', compact('eventData'));
    }

    public function deleteEvent($id = false) {

        if($id > 0) {
            Event::where('id',$id)->delete();
            EventDates::where('intFkEventId',$id)->delete();
        }
        return redirect()->route('event-list');
    }

    public function handlePost(Request $request) 
    {
        $postData = $request->all();
        
        if(!empty($postData)) {

            $event = new Event;
            $event->varTitle = $postData['title'];
            $event->dtStartDate = date('Y-m-d',strtotime($postData['startDate']));
            $event->dtEndDate = date('Y-m-d',strtotime($postData['endDate']));
            $event->varRecurrence = $postData['recurrence'];

            if($postData['recurrence'] == "RT")
            {
                $occurence  =  $postData['rt_time']. ' ' . $postData['rt_day'];
                if($postData['rt_day'] == 'day') {
                    if($postData['rt_time'] == 'every'){
                        $distance = 1;
                    }elseif($postData['rt_time'] == 'every_other'){
                        $distance = 2;
                    }elseif($postData['rt_time'] == 'every_third'){
                        $distance = 3;
                    }elseif($postData['rt_time'] == 'every_forth'){
                        $distance = 4;
                    }
                }elseif($postData['rt_day'] == 'week'){

                    if($postData['rt_time'] == 'every'){
                        $distance = 7;
                    }elseif($postData['rt_time'] == 'every_other'){
                        $distance = 7 + 2;
                    }elseif($postData['rt_time'] == 'every_third'){
                        $distance = 7 + 3;
                    }elseif($postData['rt_time'] == 'every_forth'){
                        $distance = 7 + 4;
                    }    

                }elseif($postData['rt_day'] == 'month') {

                    if($postData['rt_time'] == 'every'){
                        $distance = 30;
                    }elseif($postData['rt_time'] == 'every_other'){
                        $distance = 30 + 2;
                    }elseif($postData['rt_time'] == 'every_third'){
                        $distance = 30 + 3;
                    }elseif($postData['rt_time'] == 'every_forth'){
                        $distance = 30 + 4;
                    }    
                }elseif($postData['rt_day'] == 'year'){

                    if($postData['rt_time'] == 'every'){
                        $distance = 365;
                    }elseif($postData['rt_time'] == 'every_other'){
                        $distance = 365 + 2;
                    }elseif($postData['rt_time'] == 'every_third'){
                        $distance = 365 + 3;
                    }elseif($postData['rt_time'] == 'every_forth'){
                        $distance = 365 + 4;
                    }    
                }

            }else{

                $occurence  =  $postData['rot_day'].' ' . $postData['rot_week'].' of the '. $postData['rot_month'];
            }

            $dates = $this->displayDates($postData['startDate'], $postData['endDate'], $distance);

            $event->varOccurrence = $occurence;

            if(isset($postData['id']) && !empty($postData['id'])){
                $eventArr = $event->toArray();
                Event::where('id', $postData['id'])->update($eventArr);
                $id = $postData['id'];
            }else{
                $event->save();
                $id = $event->id;
            }
            
            
            if($id > 0) {
                if(!empty($dates)) {

                    if(isset($postData['id']) && !empty($postData['id'])) {
                        EventDates::where('intFkEventId',$id)->delete();   
                    }
                    $eventDates = array();
                    foreach($dates as $key => $value){
                        $eventDates[$key]['intFkEventId'] = $id;
                        $eventDates[$key]['dtDates'] = date('Y-m-d',strtotime($value));
                    }
                    EventDates::insert($eventDates);
                }
                return redirect()->route('event-list');
            }
        }else{
            return redirect()->route('add-event');
        }
    }


    public function displayDates($date1, $date2, $distance = false,$format = 'Y-m-d') {

        $dates = array();
        $current = strtotime($date1);
        $date2 = strtotime($date2);
        if($distance) { 
            $stepVal = '+'.$distance.' day';
        }else{
            $stepVal = '+1 day';
        }
        
        while( $current <= $date2 ) {
           $dates[] = date($format, $current);
           $current = strtotime($stepVal, $current);
        }
        return $dates;
        
     }
    

}
