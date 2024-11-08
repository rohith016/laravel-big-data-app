<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmailService;
use App\Http\Requests\uploadEmailFileRequest;

class BulkEmailController extends Controller
{

    public function __construct(public EmailService $service){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('emails.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('emails.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(uploadEmailFileRequest $request)
    {
        $result = $this -> service -> sendBulkEmails(request()->emails_csv);
        if($result['status']){
            return back()->with('success', 'Emails sent successfully!');
        }

        return back()->with('error', 'Error sending emails!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
