<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Country;
use App\Models\State;

class IndexController extends Controller
{
    public function index()
    {
        $countries = Country::getCountries();
        $states = State::getStates();
        return view('welcome', compact('countries', 'states'));
    }
}
