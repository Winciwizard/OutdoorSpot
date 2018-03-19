<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostController extends Controller
{

    /**
     * Return all comment from the current post
     *
     * Return if the current auth auth like or unlike the current post
     *
     * @return View
     */
    public function getDashboard(): View
    {
        $posts = Post::with('comments')->with('likes')->orderBy('created_at','desc')->get();

        return view('post/dashboard', ['posts' => $posts]);
    }

    /**
     * return a Json of the post
     *
     * @param Post $post
     * @return array
     */
    public function getPostJson(Post $post)
    {
        return response()->json($post);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postCreatePost(Request $request)
    {
        $this->validate($request, [
            'place' => 'required|max:100',
            'description' => 'required|max:255',
            'image' => 'required|mimes:jpg,jpeg'
        ]);


        /** @var $FILE_ERROR $fileError */

        $fileError = $_FILES['image']['error'];

        if($fileError != 0){
            return redirect()->back();
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

        //TODO: Resizer l'image

        /**
         * Create à new file name before storage
         * If file prensent, store this in folder 'public/nameoffile.jpg'
         */
        $cover = 'cover/'.md5(uniqid()).'.jpg';
        if($file) {
            Storage::disk('local')->put('public/'.$cover, File::get($file));
        }

        /** @var object $post */
        $post = new Post();
        $post->setAttribute('place', $request->input('place')) ;
        $post->setAttribute('description', $request->input('description'));
        if($latitude != 0 && $longitude != 0){
            $post->setAttribute('latitude', $latitude);
            $post->setAttribute('longitude', $longitude);
        }
        $post->setAttribute('file', $cover);
        $request->user()->posts()->save($post);

        return redirect()->route('dashboard');
    }

    /**
     * @param Post $post
     * @param Request $request
     * @return JsonResponse
     */
    public function postEditPost(Post $post, Request $request):JsonResponse
    {
        $this->validate($request, [
            'description' => 'required|max:255'
        ]);

        if (Auth::user() != $post->user){
            return redirect()->back();
        }

        $post->setAttribute('description', $request['description']);
        $post->update();
        return response()->json(['newDescription' => $post->getAttribute('description')], JsonResponse::HTTP_OK);
    }

    /**
     * @param Post $post
     * @return Response
     * @throws \Exception
     */
    public function getDeletePost(Post $post)
    {
        if (Auth::user() != $post->user){
            return redirect()->back();
        }

        $postId = $post->id;
        $file = $post->file;

        Storage::disk('local')->delete('public/'.$file);

        $post->comments()->where('post_id', '=', $postId)->delete();
        $post->likes()->where('post_id', '=', $postId)->delete();
        $post->delete();

        return redirect()->route('dashboard');
    }
}
