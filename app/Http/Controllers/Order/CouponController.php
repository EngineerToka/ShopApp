<?php

namespace App\Http\Controllers\Order;

use App\Models\Order\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Http\Resources\CopounResource;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(20);

        return response()->json([
            'status' => true,
            'message' => 'Coupons List Retrieved Successfully',
            'data' => CopounResource::collection($coupons)
        ]);
    }
    public function store(CouponRequest $request)
    {
        $coupon = Coupon::create($request->validated());
        
        return response()->json([
             'success' => true,
             'message' => 'Coupon created successfully',
             'coupon' => new CopounResource($coupon),
            ],201);
    }
    public function show($id)
    {
        $coupon = Coupon::findOrFail($id);

        return response()->json([
             'success' => true,
             'message' => 'Coupon retrived successfully',
             'coupon' => new CopounResource($coupon) ,
            ],200);
    }
    public function update(CouponRequest $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update($request->validated());
        return response()->json([
             'success' => true,
             'message' => 'Coupon updated successfully',
             'coupon' => new CopounResource($coupon) ,
            ],200);

    }
    public function destroy($id){

        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        return response()->json([
            'success' => true,
            'message' => 'Coupon deleted successfully',
        ], 200);

    }
}
