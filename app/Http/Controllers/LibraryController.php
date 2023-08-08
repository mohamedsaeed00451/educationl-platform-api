<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Traits\GeneralTrait;
use App\Models\Library;
use App\Models\LocalUrl;
use Illuminate\Support\Facades\DB;

class LibraryController extends Controller
{
    use GeneralTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Library::with('grade', 'classRoom')->paginate(PAGINATION_NUMBER);
        foreach ($books as $book) {
            $book->url = $this->getPath($book->file->filename);
            unset($book->file);
        }
        return $this->responseMessage(200, true, null, $books);
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
    public function store(AddBookRequest $request)
    {
        try {
            DB::beginTransaction();
            $book = Library::create([
                'title' => $request->title,
                'grade_id' => $request->grade_id,
                'class_room_id' => $request->class_room_id,
            ]);

            if ($request->has('book')) {
                $add_book = $this->addFile('books/' . $request->grade_id . '/' . $request->class_room_id, $request->file('book'));  //Upload book In Server
                if (!$add_book)
                    return $this->responseMessage(400, false);

                LocalUrl::create([  //Upload book In Database
                    'filename' => $add_book,
                    'urlable_id' => $book->id,
                    'urlable_type' => Library::class, //App\Models\Library
                ]);
            }

            DB::commit();
            $book->url = $this->getPath($book->file->filename);
            unset($book->file);
            return $this->responseMessage(201, true, null, $book);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseMessage(400, false, 'حدث خطأ ما');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $book = Library::find($id);
        if (!$book)
            return $this->responseMessage(400, false);
        $book->url = $this->getPath($book->file->filename);
        unset($book->file);
        return $this->responseMessage(200, true, null, $book);
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
    public function updateBook(UpdateBookRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $book = Library::find($id);
            if (!$book)
                return $this->responseMessage(400, false);
            $book->update([
                'title' => $request->title,
                'grade_id' => $request->grade_id,
                'class_room_id' => $request->class_room_id,
            ]);

            if ($request->has('book')) {
                $delete_book = $this->deleteFile($book->file->filename);
                if (!$delete_book)
                    return $this->responseMessage(400, false);
                $book->file->delete();
                $add_book = $this->addFile('books/' . $request->grade_id . '/' . $request->class_room_id, $request->file('book'));  //Upload book In Server
                if (!$add_book)
                    return $this->responseMessage(400, false);

                LocalUrl::create([  //Upload book In Database
                    'filename' => $add_book,
                    'urlable_id' => $book->id,
                    'urlable_type' => Library::class, //App\Models\Library
                ]);
            }

            DB::commit();
            $book = Library::find($id);
            $book->url = $this->getPath($book->file->filename);
            unset($book->file);

            return $this->responseMessage(201, true, null, $book);
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
            $book = Library::find($id);
            if (!$book)
                return $this->responseMessage(400, false);
                $delete_book = $this->deleteFile($book->file->filename);
                if (!$delete_book)
                    return $this->responseMessage(400, false);
                $book->file->delete();
            $book->delete();
            DB::commit();
            return $this->responseMessage(200, true, 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseMessage(400, false, 'حدث خطأ ما');
        }
    }
}
