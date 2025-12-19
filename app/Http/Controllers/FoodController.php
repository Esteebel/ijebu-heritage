<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use Inertia\Inertia;

class FoodController extends BaseController
{
    public function index()
    {
        $foods = Food::with('featuredMedia')->get();
        return $this->render('Public/FoodsIndex', [
            'foods' => $foods,
            'title' => 'Ijebu Cuisine - Ijebu Heritage',
            'description' => 'Discover the traditional foods and culinary heritage of the Ijebu people.'
        ]);
    }

    public function show(Food $food)
    {
        $food->load('featuredMedia');
        return $this->render('Public/FoodShow', [
            'food' => $food,
            'title' => $food->name . ' - Ijebu Heritage',
            'description' => $food->description
        ]);
    }
}
