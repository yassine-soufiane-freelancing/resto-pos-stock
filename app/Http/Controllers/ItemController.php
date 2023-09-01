<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Item;
use App\Models\Menu;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();
        return response()->json([
            'result' => $items,
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
    public function store(ItemRequest $request)
    {
        try {
            $item = Item::create($request->all());
            if ($item) {
                $request->whenFilled('menu', function (int $menu_id) use ($item) {
                    $menu = Menu::find($menu_id);
                    if ($menu) {
                        $item->menus()->attach($menu_id);
                    }
                });
                $result = $item;
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
    public function show(Item $item)
    {
        return response()->json([
            'result' => $item,
            'msg' => __('success'),
            'status' => 200,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        try {
            if ($item->update($request->all())) {
                $request->whenFilled('menu', function (int $menu_id) use ($item) {
                    $menu = Menu::find($menu_id);
                    if ($menu) {
                        $item->menus()->attach($menu_id);
                    }
                });
                $result = $item;
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
    public function destroy(Item $item)
    {
        try {
            if ($item->delete()) {
                $result = $item;
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
