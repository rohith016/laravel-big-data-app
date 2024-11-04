<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SaleService;

class SalesExportController extends Controller
{
    public function __construct(public SaleService $service){}
    /**
     * Undocumented function
     *
     * @return void
     */
    public function exporSalesData(){
        $result = $this -> service -> exportSalesData();

        return redirect(url('batch/'.$result))->with('success', "Reports successfully generated");
    }
}
