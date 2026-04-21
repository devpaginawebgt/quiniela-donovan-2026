<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\PushNotification;
use App\Models\UserType;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        $userTypes = UserType::orderBy('name')->get(['id', 'name', 'plural_name']);

        return view('modulos.admin.notification-form', compact('countries', 'userTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PushNotification $pushNotification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PushNotification $pushNotification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PushNotification $pushNotification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PushNotification $pushNotification)
    {
        //
    }
}
