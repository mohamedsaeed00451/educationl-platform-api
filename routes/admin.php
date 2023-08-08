<?php

use App\Http\Controllers\{AdminController,
    ClassRoomController,
    DashoardController,
    GradeController,
    LibraryController,
    QuestionController,
    QuizzeController,
    SectionController,
    StudentController,
    VideoController};

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
|
| Prefix => api/v1/admin
|
|
*/


Route::post('/login', [AdminController::class, 'login']); #login

Route::group(
    [
        'middleware' => ['jwt:admin']
    ],

    function () {


        //******************************** Auth ********************************//
        Route::controller(AdminController::class)->group(function () {

            Route::post('/logout', 'logout'); #logout
            Route::get('/profile', 'profile'); # get account data

        });

        //******************************** Dashboard  ********************************//
        Route::controller(DashoardController::class)->group(function () {

            Route::get('/dashboard-numbers','index'); #numbers
            Route::get('/dashboard-last-added', 'lastAdded'); # last added

        });


        //******************************** Grades  ********************************//
        Route::apiResource('/grades', GradeController::class);

        //******************************** ClassRooms  ********************************//
        Route::apiResource('/class-rooms', ClassRoomController::class);

        //******************************** Sections  ********************************//
        Route::apiResource('/sections', SectionController::class);

        //******************************** Students  ********************************//
        Route::apiResource('/students', StudentController::class);

        //******************************** Libraries  ********************************//
        Route::apiResource('/libraries', LibraryController::class);
        //******************************** Update Book  ********************************//
        Route::post('/update-book/{id}', [LibraryController::class,'updateBook']);

        //******************************** Videos  ********************************//
        Route::apiResource('/videos', VideoController::class);
        //******************************** Update Video  ********************************//
        Route::post('/update-video/{id}', [VideoController::class,'updateVideo']);

        //******************************** Quizzes  ********************************//
        Route::apiResource('/quizzes', QuizzeController::class);
        //******************************** Get Quizze Questions  ********************************//
        Route::get('/quizze-questions/{id}', [QuizzeController::class,'getQuizzeQuestions']);

        //******************************** Questions  ********************************//
        Route::apiResource('/questions', QuestionController::class);

    });
