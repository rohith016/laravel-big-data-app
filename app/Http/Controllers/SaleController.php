<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use App\Services\SaleService;
use App\Http\Requests\UploadSalesRequest;

class SaleController extends Controller
{

    public function __construct(public SaleService $service){

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sales.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UploadSalesRequest $request)
    {

        $result = $this->service->uploadCsv(request()->sales_csv);

        if($result['status'])
            return redirect(url('batch/'.$result['data']))->with('success', $result['message']);
        else
            return redirect()->back()->with('error', $result['message'] ?? "Failed");

    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }


    public function batch() {
        $batchId = request()->id;
        $batch = $this -> service -> getBatch($batchId);
        return view('sales.batch-progress', compact('batch'));
    }
}
