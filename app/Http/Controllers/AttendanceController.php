<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    //打刻ページ表示
    public function getIndex()
    {
        return view('index.index');
    }
    //打刻ページ表示
    public function getBreakin()
    {
        return view('index.breakin');
    }
    //打刻ページ表示
    public function getBreakout()
    {
        return view('index.breakout');
    }
    //打刻ページ表示
    public function getEnd()
    {
        return view('index.end');
    }


    //勤務開始処理
    public function startAttendance()
    {
        $user = Auth::user();

        $startTime = Attendance::where('user_id', $user->id)->latest()->first();
        if ($startTime) {
            $startTimePush = new Carbon($startTime->start_time);
            $startTimeDay = $startTimePush->startOfDay();
        }

        $newTimestampDay = Carbon::today();

        //出勤開始を連続で押す、またはend_timeカラムに値が入ってるとエラーを返す
        if (($startTime) && ($startTimeDay == $newTimestampDay) && (empty($startTime->end_time))) {
            return redirect()->back()->with('error', 'すでに出勤打刻がされています！');
        }

        $startTime = Attendance::create([
            'user_id' => $user->id,
            'date' => Carbon::today(), //打刻時の日付
            'start_time' => Carbon::now(), //出勤時間
        ]);

        return redirect()->back()->with('stampingMessage', '打刻完了！出勤しました！');
    }

    //勤務終了処理
    public function endAttendance()
    {
        $user = Auth::user();
        $endTime = Attendance::where('user_id', $user->id)->latest()->first();

        if (!empty($endTime->end_time)) {
            return redirect()->back()->with('error', 'すでに退勤打刻がされている、もしくは出勤打刻がされていません！');
        }

        $endTime->update([
            'end_time' => Carbon::now(), //退勤時間
        ]);

        return redirect()->back()->with('stampingMessage', '打刻完了！退勤しました！');
    }





    //日付一覧ページ表示
    public function getAttendance()
    {
        $attendances = Attendance::paginate(5);

        foreach ($attendances as $attendance) {
            // このループのattendanceのidを持つrestデータを取得
            $rests = $attendance->rests;

            // 休憩時間の合計秒数を取得
            $total_rest_time = 0;
            foreach ($rests as $rest) {
                $total_rest_time = $total_rest_time + strtotime($rest->breakout_time) - strtotime($rest->breakin_time) - 32400;
            }
            // 拘束時間
            $restraint_time = strtotime($attendance->end_time) - strtotime($attendance->start_time) - (32400 + 32400);

            $attendance->rest_time = date('H:i:s', $total_rest_time);
            $attendance->work_time = date('H:i:s', $restraint_time - $total_rest_time);
        }

        return view('attendance', compact('attendances'));
    }
}
