<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Station;
use App\Http\Resources\StationResource;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validation = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'lat' => 'numeric|between:-90,90|required_with:lng|required_with:radius',
            'lng' => 'numeric|between:-180,180|required_with:lat|required_with:radius',
            'radius' => 'numeric|min:1|max:200|required_with:lat|required_with:lng'
        ]);

        if($validation->fails()){

            return response()->json(["status"=>"error","messages"=>$validation->errors()]);

        } else {

            if($request->lat && $request->lng && $request->radius){

                // We will filter data by radius from the defined GPS point
                $data = Station::query()->select('stations.*')->selectRaw('(((acos(sin(('.$request->lat.'*pi()/180)) * sin((latitude*pi()/180))+cos(('.$request->lat.'*pi()/180)) * cos((latitude*pi()/180)) * cos((('.$request->lng.'-longitude)*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance')->having('distance','<',$request->radius)->get();

                //$data = Station::query()->selectRaw('(((acos(sin(('.$request->lat.'*pi()/180)) * sin((latitude*pi()/180))+cos(('.$request->lat.'*pi()/180)) * cos((latitude*pi()/180)) * cos((('.$request->lng.'-longitude)*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance')->get();
                //$data = Station::latest()->get();

            } else {

                $data = Station::latest()->get();

            }

            return StationResource::collection($data);

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'desc' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $station = Station::create([
            'name' => $request->name,
            'desc' => $request->desc
        ]);

        return response()->json(['Station created successfully.', new StationResource($station)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $station = Station::find($id);
        if (is_null($station)) {
            return response()->json('Data not found', 404);
        }
        return response()->json([new StationResource($station)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Station $station)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'desc' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $station->name = $request->name;
        $station->desc = $request->desc;
        $station->save();

        return response()->json(['Station updated successfully.', new StationResource($station)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Station $station)
    {
        $station->delete();

        return response()->json('Station deleted successfully');
    }
}
