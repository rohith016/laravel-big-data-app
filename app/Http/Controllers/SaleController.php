<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use App\Services\SaleService;
use App\Http\Requests\UploadSalesRequest;

class SaleController extends Controller
{
    /**
     * __construct function
     *
     * @param SaleService $service
     */
    public function __construct(public SaleService $service){}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $salesData = $this->service->getSalesData($request->name, $request->amount, $request->description);
        return view('sales.index', compact('salesData'));
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
        if($request->validated('type') == 'form') {
            $result =  $this -> service -> createSalesRecord($request->validated('name'), $request->validated('amount'), $request->validated('description'));
        } else if($request->validated('type') == 'file') {
            $result = $this->service->uploadCsv(request()->sales_csv);
        }

        if($request->validated('type') == 'file' && $result['status'])
            return redirect(url('batch/'.$result['data']))->with('success', $result['message']);
        else if ($request->validated('type') == 'form' && $result['status'])
            return redirect()->back()->with('success', $result['message'] ?? "Success!");
        else
            return redirect()->back()->with('error', $result['message'] ?? "Failed");

    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {

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
        if(!$batch)
            return redirect()->route('sales.create')->with('error', 'Batch not found');

        return view('sales.batch-progress', compact('batch'));
    }
}
