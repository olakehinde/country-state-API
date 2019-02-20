<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Validator;

class PassportController extends Controller
{
    public $successStatus = 200;

    public function register(Request $request) {
    	$validator = Validator::make($request->all(), [
    		'name' => 'required',
    		'email' => 'required|email',
    		'password' => 'required',
    		'confirm_password' => 'required|same:password'
    	]);

    	// check if validation fails
    	if ($validator->fails()) {
    		return response()->json(['error' => $validator->errors()], 401);
    	}

    	// if validation is successful
    	$input = $request->all();

    	// encrypt password before sending to db
    	$input['password'] = bcrypt($input['password']);

    	// create the user registration
    	$user = User::create($input);

    	$success['token'] = $user->createToken('API')->accessToken;
    	$success['name'] = $user->name;
    	$success['email'] = $user->email;

    	return response()->json(['data' => $success, 'status_code' => $this->successStatus, 'status_message' => 'Success'], $this->successStatus);
    }

    public function login(Request $request) {
    	if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
    		$user = Auth::user();

    		$success['token'] = $user->createToken('API')->accessToken;
	    	$success['email'] = $user->email;

	    	return response()->json(['data' => $success, 'status_code' => $this->successStatus, 'status_message' => 'Success'], $this->successStatus);
    	}

    	// return unauthorized error if login fails
    	return response()->json(['error' => 'Unauthorized'], 401);
    }

    // get all countries
    public function getCountries() {
        $user = Auth::user();

        $countries = Country::all();

        $success['token'] = $user->createToken('API')->accessToken;

        return response()->json(['data' => $countries, 'status_code' => $this->successStatus, 'status_message' => 'Success'], $this->successStatus);
    }

    // get the details of a single country
     public function getCountry($id) {
        $user = Auth::user();

        $country = Country::where('id', $id)->get();

        $success['token'] = $user->createToken('API')->accessToken;

        return response()->json(['data' => $country, 'status_code' => $this->successStatus, 'status_message' => 'Success'], $this->successStatus);
    }

    // get all states in a country
    public function getStates($country_id) {
        $user = Auth::user();
        
        $states = State::where('country_id', $country_id)->get();

        $success['token'] = $user->createToken('API')->accessToken;

        return response()->json(['data' => $states, 'status_code' => $this->successStatus, 'status_message' => 'Success'], $this->successStatus);
    }

    // get the details of a single state
    public function getState($id) {
        $user = Auth::user();

        $state = State::where('id', $id)->get();

        $success['token'] = $user->createToken('API')->accessToken;

        return response()->json(['data' => $state, 'status_code' => $this->successStatus, 'status_message' => 'Success'], $this->successStatus);
    }

    // get all cities in a state
    public function getCities($state_id) {
        $user = Auth::user();

        $cities = City::where('state_id', $state_id)->get();

        $success['token'] = $user->createToken('API')->accessToken;

        return response()->json(['data' => $cities, 'status_code' => $this->successStatus, 'status_message' => 'Success'], $this->successStatus);
    }

     // get details of a single city
    public function getCity($id) {
        $user = Auth::user();

        $city = City::where('id', $id)->get();

        $success['token'] = $user->createToken('API')->accessToken;

        return response()->json(['data' => $city, 'status_code' => $this->successStatus, 'status_message' => 'Success'], $this->successStatus);
    }
}