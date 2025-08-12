<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use App\Models\ProductOutlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutletController extends Controller
{
    public function index()
    {

        $data = DB::select("
            select
                o.*,
                a.name as area_name
            from outlets o
            join areas a on a.id = o.area_id
        ");

        $areas = DB::select("select * from areas where active = 1");

        return view('Master.Outlet.index', compact('data', 'areas'));
    }

    public function create(Request $request) {
        try {
            DB::beginTransaction();

            $outlet = Outlet::create([
               'name' => $request->name,
               'area_id' => $request->area,
               'description' => $request->description,
               'latitude' => $request->latitude,
               'longitude' => $request->longitude,
               'active' => 1,
            ]);

            $mandatory_products = DB::select("select * from products where mandatory = 1 and active = 1");
            foreach ($mandatory_products as $product) {
                ProductOutlet::create([
                    'product_id' => $product->id,
                    'outlet_id' => $outlet->id,
                    'price' => $product->default_price,
                    'active' => 1,
                ]);
            }



            if(auth()->user()->level == 1) {
                DB::commit();
            } else {
                DB::commit();
            }
            return response()->json([
                'message' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(["message" => $e->getMessage(), "trace" => $e->getTrace()], 500);
        }
    }

    public function update(Request $request) {
        try {
            DB::beginTransaction();


            Outlet::find($request->id)->update([
                'name' => $request->name,
                'area_id' => $request->area,
                'description' => $request->description,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'active' => $request->active,
            ]);


            if(auth()->user()->level == 1) {
                DB::commit();
            } else {
                DB::commit();
            }
            return response()->json([
                'message' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(["message" => $e->getMessage(), "trace" => $e->getTrace()], 500);
        }
    }

    public function show($id) {

        $outlet = collect(DB::select("select * from outlets where id = $id"))->first();
        $products = DB::select("
            select
                product_outlets.*,
                products.name as product_name
            from product_outlets
            join products on product_outlets.product_id = products.id
            where outlet_id = $id
        ");

        $products_can_added = DB::select("
            select
                p.*
            from products p
            left join product_outlets o on o.product_id = p.id and o.outlet_id = $id
            where o.id is null
        ");

        return view('Master.Outlet.detail', compact('outlet', 'products', 'products_can_added'));
    }

    public function addProduct(Request $request, $id) {
        try {
            DB::beginTransaction();

            $cek = DB::select("select * from product_outlets where product_id = $request->product and outlet_id = $id");
            if(count($cek) > 0) {
                throw new \Exception("Product already added");
            }

            ProductOutlet::create([
                'product_id' => $request->product,
                'outlet_id' => $id,
                'price' => $request->price,
                'active' => 1
            ]);

            if(auth()->user()->level == 1) {
                DB::commit();
            } else {
                DB::commit();
            }
            return response()->json([
                'message' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage(), "trace" => $e->getTrace()], 500);
        }
    }

    public function updateProduct(Request $request, $id) {
        try {
            DB::beginTransaction();

            ProductOutlet::find($request->product_outlet_id)->update([
                'price' => $request->price,
                'active' => $request->active,
            ]);

            if(auth()->user()->level == 1) {
                DB::commit();
            } else {
                DB::commit();
            }
            return response()->json([
                'message' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage(), "trace" => $e->getTrace()], 500);
        }
    }
}
