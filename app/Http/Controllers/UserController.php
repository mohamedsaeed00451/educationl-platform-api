<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerQuizzeRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Traits\GeneralTrait;
use App\Models\Degree;
use App\Models\Library;
use App\Models\Quizze;
use App\Models\Video;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    use GeneralTrait;

    public function login(UserLoginRequest $request)
    {

        $credentials = $request->only(['username', 'password']);

        if (!$token = auth('user')->attempt($credentials)) {
            return $this->responseMessage(401, false, 'اسم المستخدم اول كلمة المرور غير صحيح');
        }

        $user = auth('user')->user();
        $user->access_token = $token;
        $user->token_type = 'bearer';
        $user->expires_in = auth('user')->factory()->getTTL() * 60; //mention the guard name inside the auth fn
        return $this->responseMessage(200, true, null, $user);

    }

    public function profile()
    {
        return $this->responseMessage(200, true, null, auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return $this->responseMessage(200, true, 'Successfully logged out');
    }

    public function getBooks()
    {
        $books = Library::where('grade_id', auth()->user()->grade_id)
            ->where('class_room_id', auth()->user()->class_room_id)
            ->paginate(PAGINATION_NUMBER);
        foreach ($books as $book) {
            $book->url = $this->getPath($book->file->filename);
            unset($book->file);
        }
        return $this->responseMessage(200, true, null, $books);
    }

    public function getVideos()
    {
        $videos = Video::where('grade_id', auth()->user()->grade_id)
            ->where('class_room_id', auth()->user()->class_room_id)
            ->paginate(PAGINATION_NUMBER);
        foreach ($videos as $video) {
            $video->url = $this->getPath($video->file->filename);
            unset($video->file);
        }
        return $this->responseMessage(200, true, null, $videos);
    }

    public function getQuizzes()
    {
        $quizzes = Quizze::where('grade_id', auth()->user()->grade_id)
            ->where('class_room_id', auth()->user()->class_room_id)
            ->where('quizze_status', true)
            ->paginate(PAGINATION_NUMBER);
        $check_quizze = auth()->user()->degrees()->pluck('quizze_id')->toArray();
        foreach ($quizzes as $quiz) {
            $quiz->isAble = 1;
            if (in_array($quiz->id, $check_quizze)) {
                $quiz->isAble = 0;
            }
        }
        return $this->responseMessage(200, true, null, $quizzes);
    }

    public function getQuizzeQuestions($id)
    {
        $quizze = Quizze::where('id', $id)
            ->where('class_room_id', auth()->user()->class_room_id)
            ->where('quizze_status', true)
            ->where('grade_id', auth()->user()->grade_id)->first();
        if (!$quizze)
            return $this->responseMessage(400, false);
        foreach ($quizze->questions as $question) {
            $question->answers = json_decode($question->answers);
            unset($question->right_answer);
        }
        return $this->responseMessage(200, true, null, $quizze);
    }

    public function answerQuizze(AnswerQuizzeRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $quizze = Quizze::where('id', $id)
                ->where('class_room_id', auth()->user()->class_room_id)
                ->where('quizze_status', true)
                ->where('grade_id', auth()->user()->grade_id)->first();

            if (!$quizze)
                return $this->responseMessage(400, false);

            $check_quizze = auth()->user()->degrees()->where('quizze_id', $id)->first();
            if ($check_quizze)
                return $this->responseMessage(400, false, 'تم تأدية الاختبار من قبل');

            $score = 0;
            $total_score = 0;
            foreach ($quizze->questions as $question) {
                $total_score += $question->score;
                foreach ($request->answers as $answer) {
                    if ($question->id == $answer['id']) {
                        if (strcmp(trim($question->right_answer), trim($answer['right_answer'])) === 0) {
                            $score += $question->score;
                        }
                    }
                }
            }

            if ($total_score == 0)
                return $this->responseMessage(400, false, 'لا يوجد أساله لهذا الاختبار');

            Degree::create([
                'quizze_id' => $id,
                'user_id' => auth()->user()->id,
                'score' => $score
            ]);

            $data = [
                'score' => $score,
                'quizze_score' => $total_score
            ];

            DB::commit();
            return $this->responseMessage(200, true, 'تم تأدية الاختبار بنجاح', $data);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseMessage(400, false);
        }
    }

}
