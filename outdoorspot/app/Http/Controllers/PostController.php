<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostController extends Controller
{

    /**
     * Return all comment from the current post
     *
     * Return if the current auth user like or unlike the current post
     *
     * @return View
     */
    public function getDashboard(): View
    {
        $posts = Post::with('comments')->orderBy('created_at','desc')->get();
        $likes = Post::with('likes')->get();
        //TODO: récupérer le nombre total de like d'un post

        return view('post/dashboard', ['posts' => $posts, 'likes' => $likes]);
    }

    /**
     * return a Json of the post
     *
     * @param Post $post
     * @return array
     */
    public function getPostJson(Post $post): array
    {
        return $post->jsonSerialize();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postCreatePost(Request $request): Response
    {


        $this->validate($request, [
            'place' => 'required|max:100',
            'description' => 'required|max:255',
            //TODO: gérer la validate de l'image (php.ini max 8M) 'image' => 'required|image|max:400240'
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

        }

        //TODO: Gérer quand pas de coordonnées GPS
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
            $post->setAttribut('longitude', $longitude);
        }
        $post->setAttribute('file', $cover);
        $post->save();


        /** @var object $like */
        $like = new Like();
        $like->setAttribute('like', Like::UNLIKE);
        $post->likes()->save($like);

        return redirect()->back();
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

        $post->setAttribute('description', $request['description']);
        $post->update();
        return response()->json(['newDescription' => $post->getAttribute('description')], JsonResponse::HTTP_OK);
    }

    /**
     * @param Post $post
     * @return Response
     * @throws \Exception
     */
    public function getDeletePost(Post $post): Response
    {
        $post->delete();
        return redirect()->route('dashboard');
    }
}
