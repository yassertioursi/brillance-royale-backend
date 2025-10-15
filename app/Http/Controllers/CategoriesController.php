<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Traits\ApiResponseTrait;


class CategoriesController extends Controller
{
use ApiResponseTrait;
    public function index()
    {
        $categories = Category::all();
        return $this->successResponse($categories, 'Categories retrieved successfully', 200);
    }

}

