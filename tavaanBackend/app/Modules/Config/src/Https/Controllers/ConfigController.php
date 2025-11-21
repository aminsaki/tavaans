<?php

namespace holoo\modules\Config\Https\Controllers;

use App\Http\Controllers\Controller;
use holoo\modules\Config\services\ConfigServices;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function __construct(protected ConfigServices $ConfigServices)
    {}

    public function index(Request $request)
    {
        return $this->ConfigServices->getConfigData($request->all());

    }
    public function store(Request $request)
    {
        return $this->ConfigServices->createConfigeData($request->all());
    }
    public function destroy($id){

        return $this->ConfigServices->deleteConfigeData($id);
    }

}
