<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return PostResource::collection(Post::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'place' => 'required|max:100',
            'description' => 'required|max:255',
            'image' => 'required|mimes:jpg,jpeg'
        ]);


        /** @var $FILE_ERROR $fileError */

        $fileError = $_FILES['image']['error'];

        if($fileError != 0){
            return response()->json(['error' => 'Erreur fichier'], JsonResponse::HTTP_BAD_REQUEST);
        }

        /**
         * Recuperation des information d'url du fichier
         */
        $file = $request->file('image');
        $filePath = $file->getPathname();

        /**
         * Création du l'objet Imagick pour récuperer l'EXIF
         */
        $im = new \Imagick($filePath);
        $exifArray = $im->getImageProperties();

        /**Initialisation des variable $latitude et $longitude
         * @var float $latitude */
        $latitude = 0;
        /** @var float $longitude */
        $longitude = 0;

        /**
         * verification de la présence de valeur
         */
        if (isset($exifArray['exif:GPSLatitude'])){

            /**
             * Formatage et modification des données récupérés
             */
            $arrayLatitude = explode(',',$exifArray['exif:GPSLatitude']);
            $refLatitude = strtoupper($exifArray['exif:GPSLatitudeRef']);
            $arrayLongitude = explode(',',$exifArray['exif:GPSLongitude']);
            $refLongitude = strtoupper($exifArray['exif:GPSLongitudeRef']);

            /**
             * Transformation des orientation en numérique
             */
            if ($refLatitude == 'N'){
                $refLatitude = 1;
            }elseif ($refLatitude == 'S'){
                $refLatitude = -1;
            }


            if ($refLongitude == 'E'){
                $refLongitude = 1;
            }elseif ($refLongitude == 'W'){
                $refLongitude = -1;
            }

            /**
             *calcule des valeur de $latitude et $longitude
             */
            $latitude = ((float) $arrayLatitude[0] + ((float) $arrayLatitude[1]/60)+((float) $arrayLatitude[2]/3600))*$refLatitude;
            $longitude = ((float) $arrayLongitude[0]+((float) $arrayLongitude[1]/60)+((float) $arrayLongitude[2]/3600))*$refLongitude;

        } else {
            /**
             *Si pas de GPS dans l'exif, recupération du GPS via API Google GEOCODE avec la ville et le pays
             */
            /** @var string $city */
            $city = $request->place;
            /** @var string $country */
            $country = $request->country;

            /** @var string $cityclean */
            $cityclean = str_replace(' ','+', $city);
            /** @var string $countryclean */
            $countryclean = str_replace(' ','+', $country);
            /** @var string $detailUrl */
            $detailUrl = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$cityclean.'+'.$countryclean.',+CA&key=AIzaSyDajw0StZIITHHTGRKqf_0UeXh7QsqKQ5U';

            /** Appel de l'API */
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $detailUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            /** @var array $geoloc */
            $geoloc = json_decode(curl_exec($ch), true);

            /** @var float $latitude */
            $latitude = $geoloc['results'][0]['geometry']['location']['lat'];
            /** @var float $longitude */
            $longitude = $geoloc['results'][0]['geometry']['location']['lng'];

        }

        /**
         * Create à new file name before storage
         * If file prensent, store this in folder 'public/nameoffile.jpg'
         */
        $cover = 'cover/'.md5(uniqid()).'.jpg';
        if($file) {
            Storage::disk('local')->put('public/'.$cover, File::get($file));
        }
        $post = new Post();

        $post->setAttribute('place', $request->place);
        $post->setAttribute('description',$request->description);
        if($latitude != 0 && $longitude != 0){
            $post->setAttribute('latitude', $latitude);
            $post->setAttribute('longitude', $longitude);
        }
        $post->setAttribute('user_id',$request->user_id);
        $post->setAttribute('file',$cover);
        $post->save();

        return response()->json($post, JsonResponse::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return PostResource
     */
    public function show($id)
    {
        return new PostResource(Post::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'description' => 'required|max:255'
        ]);

        $post->setAttribute('description', $request['description']);
        $post->update();

        return response()->json($post, JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Post $post)
    {
        $postId = $post->id;
        $file = $post->file;

        Storage::disk('local')->delete('public/'.$file);

        $post->comments()->where('post_id', '=', $postId)->delete();
        $post->likes()->where('post_id', '=', $postId)->delete();
        $post->delete();

        return response()->json(['message' => 'Post supprimé'], JsonResponse::HTTP_OK);
    }
}
