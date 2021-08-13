<?php

namespace App\Http\Controllers;

use App\Models\Filter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilterController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        $filter = $request->get('params');
         if($filter['brand_ids'] == 0){
             $filter['brand_ids'] = [];
         }
        Filter::create([
            'user_id' => Auth::id(),
            'filter' => $filter,
        ]);

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        Filter::where('user_id', Auth::id())->delete();
        if($request->ajax()){
            return response()->json(['status' => 'success'], 200);
        }
        return back();

    }
}
