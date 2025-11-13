<?php

namespace holoo\modules\Visits\Https\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Visits\src\services\VisitServices;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function __construct(protected   VisitServices $visitServices){}

    public function index(Request $request)
    {

        return   $this->visitServices->getVisitsData($request->all());

    }
    public function serachVisits(Request $request)
    {
        return  $this->visitServices->serachVisits($request->all());
    }

  public function store(Request $request){

     return $this->visitServices->createVisiteData($request->all());
  }
   public function updateVisits(Request $request){

       return $this->visitServices->update($request->all());
   }
}
