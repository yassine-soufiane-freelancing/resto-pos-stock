<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Client;
use App\Models\Order;
use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();
        response()->json([
            'result' => $orders,
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
    public function store(OrderRequest $request)
    {
        try {
            $order = Order::create($request->all());
            if ($order) {
                $request->whenFilled('client', function (int $client_id) use ($order) {
                    $client = Client::find($client_id);
                    if ($client) {
                        $order->clients()->attach($client_id, [
                            'ticket_status' => 'to wait',
                        ]);
                    }
                });
                $request->whenFilled('table', function (int $table_id) use ($order, $request) {
                    $table = Table::find($table_id);
                    if ($table) {
                        $reserved_from = Carbon::now();
                        $reservation_attributes = [
                            'reservation_name' => 'to wait',
                            'reserved_from' => $reserved_from->toDateString(),
                            'reserved_to' => $reserved_from->addHour()->toDateString(), // TODO: make it the time that the order checkout
                        ];
                        $request->whenFilled('nb_seats', function (int $nb_seats) use ($reservation_attributes) {
                            $reservation_attributes['nb_seats'] = $nb_seats; // TODO: $nb_seats == nb_seats of the associated table
                        });
                        $order->tables()->attach($table_id, $reservation_attributes);
                    }
                });
                $result = $order;
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
    public function show(Order $order)
    {
        response()->json([
            'result' => $order,
            'msg' => __('success'),
            'status' => 200,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, Order $order)
    {
        try {
            if ($order->update($request->all())) {
                $request->whenFilled('client', function (int $client_id) use ($order) {
                    $client = Client::find($client_id);
                    if ($client) {
                        $order->clients()->attach($client_id, [
                            'ticket_status' => 'to wait',
                        ]);
                    }
                });
                $request->whenFilled('table', function (int $table_id) use ($order, $request) {
                    $table = Table::find($table_id);
                    if ($table) {
                        $reserved_from = Carbon::now();
                        $reservation_attributes = [
                            'reservation_name' => 'to wait',
                            'reserved_from' => $reserved_from->toDateString(),
                            'reserved_to' => $reserved_from->addHour()->toDateString(), // TODO: make it the time that the order checkout
                        ];
                        $request->whenFilled('nb_seats', function (int $nb_seats) use ($reservation_attributes) {
                            $reservation_attributes['nb_seats'] = $nb_seats; // TODO: $nb_seats == nb_seats of the associated table
                        });
                        $order->tables()->attach($table_id, $reservation_attributes);
                    }
                });
                $result = $order;
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
    public function destroy(Order $order)
    {
        try {
            if ($order->delete()) {
                $result = $order;
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
