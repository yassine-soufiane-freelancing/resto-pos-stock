<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashRegisterRequest;
use App\Models\CashRegister;
use App\Models\CashUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cash_registers = CashRegister::all();
        return response()->json([
            'result' => $cash_registers,
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
    public function store(CashRegisterRequest $request)
    {
        try {
            $cashRegister = new CashRegister($request->all());
            $cashRegister->cashier()->associate(Auth::user());
            $cash_unit = new CashUnit($request->cash_units);
            if ($cashRegister->save()) {
                $cash_unit->cash_register()->associate($cashRegister);
                if ($cash_unit->save()) {
                    $result = $cashRegister;
                    $msg = __('success.add');
                    $status = 200;
                } else {
                    $result = null;
                    $msg = __('failure.add');
                    $status = 500;
                }
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
    public function show(CashRegister $cashRegister)
    {
        return response()->json([
            'result' => $cashRegister,
            'msg' => __('success'),
            'status' => 200,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CashRegister $cashRegister)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CashRegisterRequest $request, CashRegister $cashRegister)
    {
        try {
            if ($cashRegister->update($request->all()) && $cashRegister->cash_unit->update($request->cash_units)) {
                $result = $cashRegister;
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
    public function destroy(CashRegister $cashRegister)
    {
        try {
            if ($cashRegister->delete()) {
                $result = $cashRegister;
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
