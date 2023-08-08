<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Http\Traits\GeneralTrait;
use App\Models\LocalUrl;
use App\Models\Video;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    use GeneralTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::with('grade', 'classRoom')->paginate(PAGINATION_NUMBER);
        foreach ($videos as $video) {
            $video->url = $this->getPath($video->file->filename);
            unset($video->file);
        }
        return $this->responseMessage(200, true, null, $videos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddVideoRequest $request)
    {
        try {
            DB::beginTransaction();
            $video = Video::create([
                'title' => $request->title,
                'grade_id' => $request->grade_id,
                'class_room_id' => $request->class_room_id,
            ]);

            if ($request->has('video')) {
                $add_video = $this->addFile('videos/' . $request->grade_id . '/' . $request->class_room_id, $request->file('video'));  //Upload Video In Server
                if (!$add_video)
                    return $this->responseMessage(400, false);

                LocalUrl::create([  //Upload Video In Database
                    'filename' => $add_video,
                    'urlable_id' => $video->id,
                    'urlable_type' => Video::class, //App\Models\Video
                ]);
            }

            DB::commit();
            $video->url = $this->getPath($video->file->filename);
            unset($video->file);
            return $this->responseMessage(201, true, null, $video);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseMessage(400, false, 'حدث خطأ ما');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $video = Video::find($id);
        if (!$video)
            return $this->responseMessage(400, false);
        $video->url = $this->getPath($video->file->filename);
        unset($video->file);
        return $this->responseMessage(200, true, null, $video);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateVideo(UpdateVideoRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $video = Video::find($id);
            if (!$video)
                return $this->responseMessage(400, false);
            $video->update([
                'title' => $request->title,
                'grade_id' => $request->grade_id,
                'class_room_id' => $request->class_room_id,
            ]);

            if ($request->has('video')) {
                $delete_video = $this->deleteFile($video->file->filename);
                if (!$delete_video)
                    return $this->responseMessage(400, false);
                $video->file->delete();
                $add_video = $this->addFile('videos/' . $request->grade_id . '/' . $request->class_room_id, $request->file('video'));  //Upload Video In Server
                if (!$add_video)
                    return $this->responseMessage(400, false);

                LocalUrl::create([  //Upload Video In Database
                    'filename' => $add_video,
                    'urlable_id' => $video->id,
                    'urlable_type' => Video::class, //App\Models\Video
                ]);
            }

            DB::commit();
            $video = Video::find($id);
            $video->url = $this->getPath($video->file->filename);
            unset($video->file);

            return $this->responseMessage(201, true, null, $video);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseMessage(400, false, 'حدث خطأ ما');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $video = Video::find($id);
            if (!$video)
                return $this->responseMessage(400, false);
            $delete_video = $this->deleteFile($video->file->filename);
            if (!$delete_video)
                return $this->responseMessage(400, false);
            $video->file->delete();
            $video->delete();
            DB::commit();
            return $this->responseMessage(200, true, 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseMessage(400, false, 'حدث خطأ ما');
        }
    }
}
