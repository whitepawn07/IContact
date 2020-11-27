<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DayOfWeekModel;
use App\EventModel;

class EventCreatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dow = $request->dow;
        $event = $request->event;
        $datefrom = $request->datefrom;
        $dateto = $request->dateto;

        $payload = [
            "eventname" => $request->event,
            "datefrom" => $request->datefrom,
            "dateto" => $request->dateto
        ];

        $eventmodel = EventModel::create($payload);
        foreach( $request->dow as $dow ){
            $dowmodel = new DayOfWeekModel(['dow' => $dow]);
            $eventmodel->dow()->save($dowmodel);
        }
        
        $event =  EventModel::whereid($eventmodel->id)->with('dow')->first();
        $events = $this->generateEvents($event);
        return response()->json(["status" => "Event Successfully Saved!", "code" => 200, "data" => $events]);

    }



    public function generateEvents( $payload ){

        $datefrom = $payload['datefrom'];
        $dateto = $payload['dateto'];
        $datefrom = date("Y-m-d",strtotime("-1 day", strtotime($datefrom)));
        
        $eventList = [];
        while (strtotime($datefrom) < strtotime($dateto)) {
            $datefrom = date ("Y-m-d", strtotime("+1 day", strtotime($datefrom)));
            foreach( $payload['dow'] as $data ){
                
                if( intval(date('w', strtotime($datefrom) )) === $data['dow'] ) {
                    array_push( $eventList, [
                        'title' => $payload['eventname'],
                        'date' => $datefrom,
                    ]);
                }
            }
        }

        return $eventList;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show ($id)
    {
        return EventModel::whereid($id)->with('dow')->first();
    }

    public function getLatest(){

        $event = EventModel::with('dow')->orderBy('id','DESC')->first();
        $events = $this->generateEvents($event);
        return response()->json(["status" => "Event Found", "code" => 200, "data" => $events]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
