<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();
        return response()->json([
            'result' => $clients,
            'msg' => __('success'),
            'status' => 200,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
        try {
            $client = Client::create($request->all());
            if ($client) {
                $result = $client;
                $msg = __('success.add');
                $status = 200;
            } else {
                $result = null;
                $msg = __('failure.add');
                $status = 500;
            }
            return response()->json([
                'result' => $result,
                'msg' => $msg,
                'status' => $status,
            ], $status);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return response()->json([
            'result' => $client,
            'msg' => __('success'),
            'status' => 200,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, Client $client)
    {
        try {
            if ($client->update($request->all())) {
                $result = $client;
                $msg = __('success.update');
                $status = 200;
            } else {
                $result = null;
                $msg = __('failure.update');
                $status = 500;
            }
            return response()->json([
                'result' => $result,
                'msg' => $msg,
                'status' => $status,
            ], $status);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        try {
            if ($client->delete()) {
                $result = $client;
                $msg = __('success.delete');
                $status = 200;
            } else {
                $result = null;
                $msg = __('failure.delete');
                $status = 500;
            }
            return response()->json([
                'result' => $result,
                'msg' => $msg,
                'status' => $status,
            ], $status);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
