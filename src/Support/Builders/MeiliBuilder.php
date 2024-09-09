<?php

namespace Support\Builders;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use MeiliSearch\Client;

class MeiliBuilder extends EloquentBuilder
{
    public function searchByFields(array $fields, array $searchString, $byIds = true)
    {
        $client = new Client(env('MEILISEARCH_HOST'), env('MEILISEARCH_KEY'));
        $index = $client->index($this->model->searchableAs());
        $index->resetSearchableAttributes();

        
        $results = collect();
        foreach ($fields as $key => $field) {
            $index->updateSearchableAttributes([$field]);

            while($index->getSearchableAttributes() !== [$field]) {
                usleep(20000);
            }

            $searchResult = $index->search($searchString[$key], ['limit' => 100], [
                'searchableAttributes' => [$field],
            ]);

            if ($results->isEmpty()) {
                $results = $results->merge(collect($searchResult->getHits()));
            } else {
                $results = $results->intersect(collect($searchResult->getHits()));
            }

        }

        if ($byIds) {
            return $this->whereIn('id', $results->pluck('id')->toArray());
        }

        return $results;
    }
}