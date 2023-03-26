<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;


class GetRepositoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GITHUB_TOKEN'),
        ])->get('https://api.github.com/user/repos');

        $repositories = collect($response->json())->filter(function ($repository) {
            return !$repository['fork'];
        })->toArray();

        $count = count($repositories);

        $filter = $request->input('filter');
        $search = $request->input('search');
        $since = $request->input('since');
        $until = $request->input('until');
        $language = $request->input('language');
        $is_private = $request->input('private');
        
        
    
        if ($filter) {
            switch ($filter) {
                case 'archived':
                    $repositories = collect($repositories)->filter(function ($repository) {
                        return $repository['archived'];
                    })->toArray();
                    break;
                case 'not_archived':
                    $repositories = collect($repositories)->filter(function ($repository) {
                        return !$repository['archived'];
                    })->toArray();
                    break;
            }
        }
        if ($is_private) {
            switch ($is_private) {
                case 'private':
                    $repositories = collect($repositories)->filter(function ($repository) {
                        return $repository['private'];
                    })->toArray();
                    break;
                case 'public':
                    $repositories = collect($repositories)->filter(function ($repository) {
                        return !$repository['private'];
                    })->toArray();
                    break;
            }
        }

        if ($search) {
            $repositories = collect($repositories)->filter(function ($repository) use ($search) {
                return stripos($repository['name'], $search) !== false || stripos($repository['language'], $search) !== false;
            })->toArray();
        }

        if ($since) {
            $repositories = collect($repositories)->filter(function ($repository) use ($since) {
                return Carbon::parse($repository['pushed_at'])->greaterThanOrEqualTo(Carbon::parse($since));
            })->toArray();
        }
    
        if ($until) {
            $repositories = collect($repositories)->filter(function ($repository) use ($until) {
                return Carbon::parse($repository['pushed_at'])->lessThanOrEqualTo(Carbon::parse($until));
            })->toArray();
        }


        $sort = $request->input('sort');

        if ($sort) {
            switch ($sort) {
                case 'name_asc':
                    $repositories = collect($repositories)->sortBy('name')->toArray();
                    break;
                case 'name_desc':
                    $repositories = collect($repositories)->sortByDesc('name')->toArray();
                    break;
                case 'last_commit_asc':
                    $repositories = collect($repositories)->sortBy('pushed_at')->toArray();
                    break;
                case 'last_commit_desc':
                    $repositories = collect($repositories)->sortByDesc('pushed_at')->toArray();
                    break;
            }
        }

        return view('repositories.index', compact('repositories', 'count'));
    }
}

