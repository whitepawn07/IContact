<?php

namespace App\Http\Controllers;


// use App\Interfaces\ContactsInterfaces;
use Illuminate\Http\Request;

use App\Contacts;

class ContactsController extends Controller
{   
    // private $contactsInterfaces;

    // public function __construct(ContactsInterfaces $contactsInterfaces)
    // {
    //     $this->contactsInterfaces = $contactsInterfaces;
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user()->id;
        return response()->json(Contacts::where('user_id', $user)->with(['user', 'customAttributes'])->get());
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
        $responseData = array();
        $data = $request->all();
        foreach($data as $d) {
            $contact = Contacts::firstOrCreate([
                'user_id' => $request->user()->id,
                'name' => $d['name'],
                'phone' => $d['phone'],
                'email' => $d['email']
            ]);
            
            foreach($d['custom'] as $custom) {
                $contact->customAttributes()->firstOrCreate([
                    'key' => $custom['key'],
                    'value' => $custom['value']
                ]);
            }
        }
        return response()->json($contact->with(['user','customAttributes'])->get());
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
