<?php

namespace App\Api\Controllers;

abstract class Controller
{
    protected function searchIndex(string $model, $request)
    {
        $pagination = $request->input('pagination');

        $select = $request->input('select');

        $search = $request->input('search', []);

        $query = $model::query();

        if ($select) {
            $query->select(explode(',', $select));
        }

        $searchTerm = collect([]);
        foreach ($search as $key => $value) {
            if (collect($model::getSearchable())->contains($key)) {
                $searchTerm = $searchTerm->merge($search);
                continue;
            }

            $query->where($key, $value);
        }
        if (!$searchTerm->isEmpty()) {
            $query->searchByFields($searchTerm->keys()->toArray(), $searchTerm->values()->toArray());
        }

        if($pagination) {
            if ($pagination['sortBy'] ?? false) {
                $desc = filter_var($pagination['descending'] ?? 'false', FILTER_VALIDATE_BOOLEAN) ?? false;
                $query->orderBy($pagination['sortBy'], $desc ? 'desc' : 'asc');
            }
    
            $response = $query->paginate($pagination['rowsPerPage'] ?? null, ['*'], 'page', $pagination['page'] ?? null)->toArray();
    
            if ($pagination['sortBy'] ?? false) {
                $response['sortBy'] = $pagination['sortBy'] ?? 'id';
                $response['descending'] = filter_var($pagination['descending'] ?? 'false', FILTER_VALIDATE_BOOLEAN);
            }

            return $response;
        }

        return $query->get();
    }
}
