<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\CashRegister;
use App\Models\ItemVariation;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Fluent;

class DashboardController extends Controller
{
    function ca_net(Request $request): JsonResponse
    {
        return response()->json([
            'result' => 0,
        ]);
    }
    function ca_gross(Request $request): JsonResponse
    {
        $this->validate_dates($request);
        $ca_gross = Order::when($request->by, function (Builder $query, int $user_id) {
            $query->whereRelation('cashier', 'user_id', $user_id);
        })
            ->when($request->date_begin, function (Builder $query, string $date_begin) {
                $query->where('created_at', '>=', $date_begin);
            })
            ->when($request->date_end, function (Builder $query, string $date_end) {
                $query->where('created_at', '<=', $date_end);
            })
            ->with('item_variations')
            ->get()
            ->sum(function (Order $order) {
                return $order->item_variations->sum(function (ItemVariation $itemVariation) {
                    return $itemVariation->pivot->item_quantity * $itemVariation->item_price;
                });
            });
        return response()->json([
            'result' => $ca_gross,
        ]);
    }
    function ca_by_payment_methods(Request $request): JsonResponse
    {
        $ca_cash = Order::when($request->by, function (Builder $query, int $user_id) {
            $query->whereRelation('cashier', 'user_id', $user_id);
        })
            ->when($request->date_begin, function (Builder $query, string $date_begin) {
                $query->where('created_at', '>=', $date_begin);
            })
            ->when($request->date_end, function (Builder $query, string $date_end) {
                $query->where('created_at', '<=', $date_end);
            })
            ->where('payment_type', 'cash')
            ->with('item_variations')
            ->get()
            ->sum(function (Order $order) {
                return $order->item_variations->sum(function (ItemVariation $itemVariation) {
                    return $itemVariation->pivot->item_quantity * $itemVariation->item_price;
                });
            });
        $ca_card = Order::when($request->by, function (Builder $query, int $user_id) {
            $query->whereRelation('cashier', 'user_id', $user_id);
        })
            ->when($request->date_begin, function (Builder $query, string $date_begin) {
                $query->where('created_at', '>=', $date_begin);
            })
            ->when($request->date_end, function (Builder $query, string $date_end) {
                $query->where('created_at', '<=', $date_end);
            })
            ->where('payment_type', 'card')
            ->with('item_variations')
            ->get()
            ->sum(function (Order $order) {
                return $order->item_variations->sum(function (ItemVariation $itemVariation) {
                    return $itemVariation->pivot->item_quantity * $itemVariation->item_price;
                });
            });
        $ca_by_payment_methods = [
            'ca_cash' => $ca_cash,
            'ca_card' => $ca_card,
        ];
        return response()->json([
            'result' => $ca_by_payment_methods,
        ]);
    }
    function ca_off(Request $request): JsonResponse
    {
        $ca_off = Order::when($request->by, function (Builder $query, int $user_id) {
            $query->whereRelation('cashier', 'user_id', $user_id);
        })
            ->when($request->date_begin, function (Builder $query, string $date_begin) {
                $query->where('created_at', '>=', $date_begin);
            })
            ->when($request->date_end, function (Builder $query, string $date_end) {
                $query->where('created_at', '<=', $date_end);
            })
            ->where('order_status', OrderStatus::RETURNED())
            ->with('item_variations')
            ->get()
            ->sum(function (Order $order) {
                return $order->item_variations->sum(function (ItemVariation $itemVariation) {
                    return $itemVariation->pivot->item_quantity * $itemVariation->item_price;
                });
            });
        return response()->json([
            'result' => $ca_off,
        ]);
    }
    function tip(Request $request): JsonResponse
    {
        $tip = Order::when($request->by, function (Builder $query, int $user_id) {
            $query->whereRelation('cashier', 'user_id', $user_id);
        })
            ->when($request->date_begin, function (Builder $query, string $date_begin) {
                $query->where('created_at', '>=', $date_begin);
            })
            ->when($request->date_end, function (Builder $query, string $date_end) {
                $query->where('created_at', '<=', $date_end);
            })
            ->sum('order_tip');
        return response()->json([
            'result' => $tip,
        ]);
    }
    function nb_tickets(Request $request): JsonResponse
    {
        $nb_tickets = Order::when($request->by, function (Builder $query, int $user_id) {
            $query->whereRelation('cashier', 'user_id', $user_id);
        })
            ->when($request->date_begin, function (Builder $query, string $date_begin) {
                $query->where('created_at', '>=', $date_begin);
            })
            ->when($request->date_end, function (Builder $query, string $date_end) {
                $query->where('created_at', '<=', $date_end);
            })
            ->count();
        return response()->json([
            'result' => $nb_tickets,
        ]);
    }
    function nb_tickets_by_payment_methods(Request $request): JsonResponse
    {
        $nb_tickets_cash = Order::where('payment_type', 'cash')
            ->when($request->date_begin, function (Builder $query, string $date_begin) {
                $query->where('created_at', '>=', $date_begin);
            })
            ->when($request->date_end, function (Builder $query, string $date_end) {
                $query->where('created_at', '<=', $date_end);
            })
            ->when($request->by, function (Builder $query, int $user_id) {
                $query->whereRelation('cashier', 'user_id', $user_id);
            })
            ->count();
        $nb_tickets_card = Order::where('payment_type', 'card')
            ->when($request->date_begin, function (Builder $query, string $date_begin) {
                $query->where('created_at', '>=', $date_begin);
            })
            ->when($request->date_end, function (Builder $query, string $date_end) {
                $query->where('created_at', '<=', $date_end);
            })
            ->when($request->by, function (Builder $query, int $user_id) {
                $query->whereRelation('cashier', 'user_id', $user_id);
            })
            ->count();
        $nb_tickets = [
            'nb_tickets_cash' => $nb_tickets_cash,
            'nb_tickets_card' => $nb_tickets_card,
        ];
        return response()->json([
            'result' => $nb_tickets,
        ]);
    }
    function nb_tickets_by_order_types(Request $request): JsonResponse
    {
        $nb_tickets_on_site = Order::has('tables')
            ->when($request->date_begin, function (Builder $query, string $date_begin) {
                $query->where('created_at', '>=', $date_begin);
            })
            ->when($request->date_end, function (Builder $query, string $date_end) {
                $query->where('created_at', '<=', $date_end);
            })
            ->when($request->by, function (Builder $query, int $user_id) {
                $query->whereRelation('cashier', 'user_id', $user_id);
            })
            ->count();
        $nb_tickets_imported = Order::has('imported_order')
            ->when($request->date_begin, function (Builder $query, string $date_begin) {
                $query->where('created_at', '>=', $date_begin);
            })
            ->when($request->date_end, function (Builder $query, string $date_end) {
                $query->where('created_at', '<=', $date_end);
            })
            ->when($request->by, function (Builder $query, int $user_id) {
                $query->whereRelation('cashier', 'user_id', $user_id);
            })
            ->count();
        $nb_tickets_delivered = Order::has('delivered_order')
            ->when($request->date_begin, function (Builder $query, string $date_begin) {
                $query->where('created_at', '>=', $date_begin);
            })
            ->when($request->date_end, function (Builder $query, string $date_end) {
                $query->where('created_at', '<=', $date_end);
            })
            ->when($request->by, function (Builder $query, int $user_id) {
                $query->whereRelation('cashier', 'user_id', $user_id);
            })
            ->count();
        $nb_tickets = [
            'nb_tickets_on_site' => $nb_tickets_on_site,
            'nb_tickets_imported' => $nb_tickets_imported,
            'nb_tickets_delivered' => $nb_tickets_delivered,
        ];
        return response()->json([
            'result' => $nb_tickets,
        ]);
    }
    function total(Request $request): JsonResponse
    {
        $total_estimated = Order::when($request->by, function (Builder $query, int $user_id) {
            $query->whereRelation('cashier', 'user_id', $user_id);
        })
            ->when($request->date_begin, function (Builder $query, string $date_begin) {
                $query->where('created_at', '>=', $date_begin);
            })
            ->when($request->date_end, function (Builder $query, string $date_end) {
                $query->where('created_at', '<=', $date_end);
            })
            ->where('payment_type', 'cash')->with('item_variations')
            ->get()
            ->sum(function (Order $order) {
                return $order->item_variations->sum(function (ItemVariation $itemVariation) {
                    return $itemVariation->pivot->item_quantity * $itemVariation->item_price;
                });
            })
            + CashRegister::when($request->by, function (Builder $query, int $user_id) {
                $query->whereRelation('cashier', 'user_id', $user_id);
            })
            ->when($request->date_begin, function (Builder $query, string $date_begin) {
                $query->where('created_at', '>=', $date_begin);
            })
            ->when($request->date_end, function (Builder $query, string $date_end) {
                $query->where('created_at', '<=', $date_end);
            })
            ->where('register_type', 'in')
            ->get()
            ->sum(function (CashRegister $cashRegister) {
                return collect($cashRegister->cash_units)->reduce(function (?int $carry, int $value, string $key) {
                    return $carry + ($value * floatval(config('cash_units.' . $key)));
                });
            });
        return response()->json([
            'result' => $total_estimated,
        ]);
    }
    function total_reel(Request $request): JsonResponse
    {
        $total_reel = CashRegister::when($request->by, function (Builder $query, int $user_id) {
            $query->whereRelation('cashier', 'user_id', $user_id);
        })
            ->when($request->date_begin, function (Builder $query, string $date_begin) {
                $query->where('created_at', '>=', $date_begin);
            })
            ->when($request->date_end, function (Builder $query, string $date_end) {
                $query->where('created_at', '<=', $date_end);
            })
            ->where('register_type', 'out')
            ->get()
            ->sum(function (CashRegister $cashRegister) {
                return collect($cashRegister->cash_units)->reduce(function (?int $carry, int $value, string $key) {
                    return $carry + ($value * floatval(config('cash_units.' . $key)));
                });
            });
        return response()->json([
            'result' => $total_reel,
        ]);
    }
    private function validate_dates(Request $request): void
    {
        $validator = Validator::make(
            $request->only([
                'date_begin',
                'date_end',
            ]),
            [
                'date_begin' => [
                    'sometimes',
                    'date_format:Y-m-d,Y-m-d H:i:s',
                ],
            ]
        );
        $validator->sometimes('date_end', [
            'date',
            'after:date_begin',
        ], function (Fluent $input) {
            return $input->date_begin;
        });
        $validator->validated();
    }
}
