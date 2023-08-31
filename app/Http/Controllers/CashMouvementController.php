<?php

namespace App\Http\Controllers;

use App\Models\cashMouvement;
use Illuminate\Http\Request;

class CashMouvementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cash_mouvements = cashMouvement::all();
        response()->json([
            'result' => $cash_mouvements,
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
    public function store(Request $request)
    {
        try {
            $request->whenHas('image_url', function ($imageInp) use (&$request) {
                $request->merge([
                    'image_url' => 'storage/' . $imageInp->store('images_urls'),
                ]);
            });
            $cashMouvement = cashMouvement::create($request->all());
            if ($cashMouvement) {
                $result = $cashMouvement;
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
    public function show(cashMouvement $cashMouvement)
    {
        response()->json([
            'result' => $cashMouvement,
            'msg' => __('success'),
            'status' => 200,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cashMouvement $cashMouvement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, cashMouvement $cashMouvement)
    {
        try {
            $request->whenHas('image_url', function ($imageInp) use (&$request) {
                $request->merge([
                    'image_url' => 'storage/' . $imageInp->store('images_urls'),
                ]);
            });
            if ($cashMouvement->update($request->all())) {
                $result = $cashMouvement;
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
    public function destroy(cashMouvement $cashMouvement)
    {
        try {
            if ($cashMouvement->delete()) {
                $result = $cashMouvement;
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
