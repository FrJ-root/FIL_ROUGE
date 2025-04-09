<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request){
        $query = $request->input('query');
        
        return view('search.results', [
            'query' => $query,
            'results' => []
        ]);
    }
}
