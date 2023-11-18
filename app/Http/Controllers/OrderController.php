<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\OrderRequest;
use App\Models\Client;
use App\Models\DeliveredOrder;
use App\Models\ImportedOrder;
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
        return response()->json([
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
            $order = new Order($request->all());
            $request->whenFilled('client', function (int $client_id) use ($order) {
                $client = Client::find($client_id);
                if ($client) {
                    $order->client()->associate($client_id);
                }
            });
            if ($order->save()) {
                $order->item_variations()->attach($request->item_variations);
                $request->whenFilled('table', function (int $table_id) use ($order, $request) {
                    $table = Table::find($table_id);
                    if ($table) {
                        $reservation_attributes = [
                            'reserved_from' => Carbon::now(),
                        ];
                        $request->whenFilled('nb_seats', function (int $nb_seats) use ($reservation_attributes) {
                            $reservation_attributes['nb_seats'] = $nb_seats;
                        });
                        $order->tables()->attach($table_id, $reservation_attributes);
                    }
                });
                $request->whenFilled('import', function (bool $is_import) use ($order, $request) {
                    $importedOrder = new ImportedOrder;
                    $order->imported_order()->save($importedOrder);
                });
                $request->whenFilled('delivery', function (bool $is_delivery) use ($order, $request) {
                    $deliveryOrder = new DeliveredOrder($request->all());
                    $order->delivered_order()->save($deliveryOrder);
                });
                $result = $order->refresh();
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
        return response()->json([
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
            $request->whenFilled('client', function (int $client_id) use ($order) {
                $client = Client::find($client_id);
                if ($client) {
                    $order->client()->associate($client_id);
                }
            });
            if ($order->update($request->all())) {
                $order->item_variations()->sync($request->item_variations);
                $request->whenFilled('table', function (int $table_id) use ($order, $request) {
                    $order->imported_order()->delete();
                    $order->delivered_order()->delete();
                    $table = Table::find($table_id);
                    if ($table) {
                        if ($request->order_status->equals(OrderStatus::COMPLETED())) {
                            $reservation_attributes = [
                                'reserved_to' => Carbon::now(),
                            ];
                        }
                        $request->whenFilled('nb_seats', function (int $nb_seats) use ($reservation_attributes) {
                            $reservation_attributes['nb_seats'] = $nb_seats;
                        });
                        $order->tables()->updateExistingPivot($table_id, $reservation_attributes);
                    }
                });
                $request->whenFilled('import', function (bool $is_import) use ($order, $request) {
                    if (!$order->imported_order) {
                        $order->tables()->detach();
                        $order->delivered_order()->delete();
                        $importedOrder = new ImportedOrder;
                        $order->imported_order()->save($importedOrder);
                    }
                });
                $request->whenFilled('delivery', function (bool $is_delivery) use ($order, $request) {
                    if (!$order->delivered_order) {
                        $order->tables()->detach();
                        $order->imported_order()->delete();
                        $deliveryOrder = new DeliveredOrder($request->all());
                        $order->delivered_order()->save($deliveryOrder);
                    } else {
                        $order->delivered_order->update($request->all());
                    }
                });
                $result = $order->refresh();
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
