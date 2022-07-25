<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Partner;
use App\Http\Resources\PartnerCollection;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
      $partners = Partner::query();

      if($request->has('country')){
        $partners = $partners->where('countries_covered', 'like', '%' . $request->get('country') . '%');
      }
      if($request->has('state')){
        $partners = $partners->where('states_covered', 'like', '%' . $request->get('state') . '%');
      }
      if($request->has('status') && in_array($request->get('status'), Partner::getStatuses())){
        $partners = $partners->where('status', $request->get('status'));
      }
      if($request->has('search')){
        $partners = $partners->where('company', 'like', '%' . $request->get('search') . '%');
      }

      if($request->has('collection') && $request->get('collection') == 1){
        return new PartnerCollection(Partner::all());
      }

      return $partners->get();
    }
}
