<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponseTrait;
use App\Models\Product;
use Illuminate\Http\Request;
class ProductsController extends Controller
{
    use ApiResponseTrait;


    public function all(Request $request){
        $query = Product::query();
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->integer('category_id'));
        }
        $products = $query->latest()->get();
        return $this->successResponse($products, 'Products retrieved successfully', 200);
    }

    public function getPromoProducts(){
        $products = Product::promotions()
            ->where(function($q){
                $now = now();
                $q->whereNull('promo_start_date')->orWhere('promo_start_date','<=',$now);
            })
            ->where(function($q){
                $now = now();
                $q->whereNull('promo_end_date')->orWhere('promo_end_date','>=',$now);
            })
            ->orderByDesc('promo_start_date')
            ->limit(6)
            ->get();
        return $this->successResponse($products, 'Promotional products (max 6) retrieved successfully', 200);
    }

    public function latest(){
        $products = Product::latest()->limit(6)->get();
        return $this->successResponse($products, 'Latest 6 products retrieved successfully', 200);
    }

}
