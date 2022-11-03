<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class GetRepositoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // withBasicAuth('globalr7on@gmail.com', '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')->
        $response = http::get('https://api.github.com/users/globalr7on/repos');
     
        // dd($response->json());
        $result=$response->json();

        $repositories=[];
        
        for($i = 0; $i < count($result); ++$i) {
            $miarray=array(
                "name" => $result[$i]['name'],
                "url"  => $result[$i]['url'],
                "commit"  => $result[$i]['pushed_at'],
                "archived"  => $result[$i]['archived']
            );
            array_push($repositories, $miarray);
        }
       
        return view('index',['repositories'=>$repositories]);
    }
}
