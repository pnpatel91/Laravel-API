<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use Validator;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {	
    	$input = $request->all();

    	if(count($input) > 0){
    		
    		$cars = Car::query();
    		if(isset($input['name'])){
    			$cars->where('name', 'LIKE', "%{$input['name']}%");
    		}
    		if(isset($input['colour'])){
    			$cars->where('colour', $input['colour']);
    		}
    		if(isset($input['price'])){
    			$cars->where('price', '>=', $input['price']);
    		}
    		if(isset($input['plate'])){
    			$cars->where('plate', 'LIKE', "%{$input['plate']}%");
    		}
    		if(isset($input['doors'])){
    			$cars->where('doors', '=', $input['doors']);
    		}
    		if(isset($input['transmission'])){
    			$cars->where('transmission', $input['transmission']);
    		}
    		if(isset($input['fuel'])){
    			$cars->where('fuel', $input['fuel']);
    		}
			   	$data = $cars->get();
    	}else{
        	$cars = Car::all();
        	$data = $cars->toArray();
    	}


        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'cars retrieved successfully.'
        ];

        return response()->json($response, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
       
        $validator = Validator::make($input, [
            'name' => 'required',
            'colour' => 'required',
            'price'  => 'required|numeric',
            'plate' => 'required',
            'doors' => 'required|numeric',
            'transmission' => 'required',
            'fuel' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $car = Car::create($input);
        $data = $car->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Car stored successfully.'
        ];

        return response()->json($response, 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = Car::find($id);
        $data = $car->toArray();

        if (is_null($car)) {
            $response = [
                'success' => false,
                'data' => 'Empty',
                'message' => 'Car not found.'
            ];
            return response()->json($response, 404);
        }


        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Book retrieved successfully.'
        ];

        return response()->json($response, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
    	$car = Car::find($id);
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'colour' => 'required',
            'price'  => 'required|numeric',
            'plate' => 'required',
            'doors' => 'required|numeric',
            'transmission' => 'required',
            'fuel' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        $car->name = $input['name'];
        $car->colour = $input['colour'];
        $car->price = $input['price'];
        $car->plate = $input['plate'];
        $car->doors = $input['doors'];
        $car->transmission = $input['transmission'];
        $car->fuel = $input['fuel'];
        $car->save();

        $data = $car->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Car updated successfully.'
        ];

        return response()->json($response, 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$car = Car::find($id);
        $data = $car;
        $car->delete();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Car deleted successfully.'
        ];

        return response()->json($response, 200);
    }
}
