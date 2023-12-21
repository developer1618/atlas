<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Botble\SimpleSlider\Models\SimpleSlider;
use Botble\SimpleSlider\Models\SimpleSliderItem;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        // Получить все слайды из модели SimpleSliderItem
        $slides = SimpleSliderItem::all();

        // Теперь у вас есть все слайды в переменной $slides
        // Вы можете передать их в представление или сделать с ними что-то еще

        return response()->json($slides); // Вернуть слайды в формате JSON, например, для использования в API
    }
}