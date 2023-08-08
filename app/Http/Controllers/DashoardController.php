<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\ClassRoom;
use App\Models\Grade;
use App\Models\Library;
use App\Models\Quizze;
use App\Models\Section;
use App\Models\User;
use App\Models\Video;

class DashoardController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        $data['students'] = User::all()->count();
        $data['grades'] = Grade::all()->count();
        $data['classrooms'] = ClassRoom::all()->count();
        $data['sections'] = Section::all()->count();
        $data['Quizzes'] = Quizze::all()->count();
        $data['videos'] = Video::all()->count();
        $data['books'] = Library::all()->count();
        return $this->responseMessage(200, true, null, $data);
    }

    public function lastAdded()
    {
        $data['students'] = User::latest()->take(5)->get();
        $data['grades'] = Grade::latest()->take(5)->get();
        $data['classrooms'] = ClassRoom::latest()->take(5)->get();
        $data['sections'] = Section::latest()->take(5)->get();
        $data['Quizzes'] = Quizze::latest()->take(5)->get();
        $data['videos'] = Video::latest()->take(5)->get();
        $data['books'] = Library::latest()->take(5)->get();
        return $this->responseMessage(200, true, null, $data);
    }


}
