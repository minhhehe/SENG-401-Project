<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ImageResource;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getBasedOnText($text) {

        $params = array(
            'api_key' => '334ebb0707c2e188c4522643802154df',
            'method' => 'flickr.photos.search',
            'text' => $text,
            'per_page' => '6',
            'page' => '1',
            'format' => 'json',
            'nojsoncallback' => '1',
        );

        $encoded_params = array();

        foreach ($params as $k => $v){
            $encoded_params[] = urlencode($k).'='.urlencode($v);
        }
        $url = "https://api.flickr.com/services/rest/?".implode('&', $encoded_params);
        $rsp = file_get_contents($url);
        $rsp = str_replace( 'jsonFlickrApi(', '', $rsp );
        $rsp = substr( $rsp, 0, strlen( $rsp ) );
        $rsp2 = json_decode($rsp, true);
        $photos = $rsp2['photos']['photo'];

        $images = array();
        $length = sizeof($photos);

        for ($i = 0; $i<$length; $i++) {
            $imgsrc = 'https://farm'.$photos[$i]["farm"].'.staticflickr.com/'.
            $photos[$i]["server"] . '/'.$photos[$i]["id"].'_'.$photos[$i]["secret"].'.jpg';
            array_push($images, $imgsrc);
        }
        return $images;
    }
}
