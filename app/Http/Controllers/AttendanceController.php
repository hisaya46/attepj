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
        return view('index');
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

        if (($startTime)&&($startTimeDay == $newTimestampDay) && (empty($startTime->end_time))) {
            return redirect()->back()->with('error', 'すでに出勤打刻がされています！');
        }

        $timestamp = Attendance::create([
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
        $endTimestamp = Attendance::where('user_id', $user->id)->latest()->first();

        if (!empty($endTimestamp->end_time)) {
            return redirect()->back()->with('error', 'すでに退勤打刻がされている、もしくは出勤打刻がされていません！');
        }

        $endTimestamp->update([
            'end_time' => Carbon::now()
        ]);

        return redirect()->back()->with('stampingMessage', '打刻完了！退勤しました！');
    }





    //日付一覧ページ表示
    public function getAttendance()
    {

        $attendances = Attendance::all();

        $rest_times = Rest::select(DB::raw('TIMEDIFF(breakout_time,breakin_time) as rest_time'))->get();

        $restraint_times = Attendance::select(DB::raw('TIMEDIFF(end_time,start_time) as restraint_time'))->get();
        //dd($attendances, $rest_times, $restraint_times); //取得できてるか確認

        $rest_times_c = strtotime($rest_times);
        $restraint_times_c = strtotime($restraint_times);
        $diff = $restraint_times_c - $rest_times_c;

        $work_times = date("H:i:s", $diff);


        return view('attendance', compact('attendances', 'work_times'));
    }
}
