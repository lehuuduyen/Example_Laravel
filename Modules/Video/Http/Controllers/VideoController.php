<?php

namespace Modules\Video\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\BaseController;
use Modules\Video\Http\Requests\StoreVideoRequest;
use Modules\Video\Entities\Video;

class VideoController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('video::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('video::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(StoreVideoRequest $request)
    {
        try{
            $video = new Video($request->dataOnly());
            // Upload thumbnail
            $thumbnail = Self::upload($request['thumbnail'],".jpg");
            // Upload Video
            $file = Self::upload($request['file'],".mp4");
            $video->save();
            Video::find($video->id)->update(['thumbnail' => $thumbnail, 'file' => $file]);
            return $this->responseSuccess($video,'Thêm video thành công!',200);
        }catch (Exception $exception){
            return $this->responseServerError($exception->getMessage(),NULL,500);
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('video::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('video::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    public function upload($file,$extension){
        // Upload thumbnail
        $content = file_get_contents($file);
        $filename ="image-".rand()."-".time().$extension;
        trim($filename);
        $filenamesave = '/storage/app/public/videos/'.$filename;
        file_put_contents('./storage/app/public/videos/'.$filename, $content);
        return $filenamesave;
    }
}
