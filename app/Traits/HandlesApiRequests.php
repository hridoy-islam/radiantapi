<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;
trait HandlesApiRequests
{
    protected function handleApiRequest(Request $request, Builder $query)
    {
        $page = $request->query('page', 1);
        $limit = $request->query('limit', 10);
        $sortBy = $request->query('sortBy');
        $sortDirection = $request->query('sortDirection', 'asc');
        



        // Apply filters
        foreach ($request->query() as $key => $value) {
            if ($key !== 'page' && $key !== 'limit' && $key !== 'searchTerm' && $key !== 'sortBy' && $key !== 'sortDirection') {
                $query->where($key, $value);
            }
        }

        // Apply search
        $searchTerm = $request->query('searchTerm');
        if ($searchTerm!== null) {
            $columns = Schema::getColumnListing($query->getModel()->getTable());
            $query->where(function ($query) use ($searchTerm, $columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', "%$searchTerm%");
                }
            });
        }

        // Apply sorting
        if ($sortBy) {
            $query->orderBy($sortBy, $sortDirection);
        }

        // Paginate and format response
        $results = $query->paginate($limit, ['*'], 'page', $page);

        // Extract relevant pagination data
        $meta = [
            'page' => $page,
            'limit' => $limit,
            'total' => $results->total(),
            'totalPage' => $results->lastPage(),
        ];

        // Format response data
        $result = $results->items();

        return compact('meta', 'result');
    }

    
}
