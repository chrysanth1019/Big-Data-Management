<?php

namespace App\Http\Controllers;

use App\Models\SearchResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    /**
     * Display the search form
     */
    public function index()
    {
        return view('search.index');
    }

    /**
     * Perform the search and return results
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'query' => 'required|string|min:2',
            'category' => 'nullable|string',
        ], [
            'query.required' => '検索キーワードを入力してください。',
            'query.min' => '検索キーワードは2文字以上である必要があります。',
        ]);

        if ($validator->fails()) {
            return redirect()->route('search.index')
                ->withErrors($validator)
                ->withInput();
        }

        // This would usually connect to a database, but for this MVP we'll create some dummy results
        // In a real application, you would replace this with actual database queries
        $results = [];
        $query = $request->query;
        $category = $request->category;
        
        // Sample search logic - in real application, this would query a database
        if ($query) {
            // Get results from the SearchResult model
            $results = SearchResult::search($query, $category);
        }

        return view('search.results', [
            'results' => $results,
            'query' => $query,
            'category' => $category
        ]);
    }
}
