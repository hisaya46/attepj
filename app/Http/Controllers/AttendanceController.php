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

        return redirect('/breakin')->with('stampingMessage', '打刻完了！出勤しました！');
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

        return redirect('/end')->with('stampingMessage', '打刻完了！退勤しました！');
    }

    //日付一覧ページ
    public function getAttendance(Request $request)
    {
        if ($request->page) {
            $date = $request->date; // 現在指定している日付を取得
        } else {
            $date = Carbon::today()->format("Y-m-d");
        }
        $attendances = Attendance::whereDate('date', $date)->orderBy('user_id', 'asc')->paginate(5);
        $attendances->appends(compact('date')); //日付を渡す

        foreach ($attendances as $attendance) {
            foreach ($attendances as $attendance) {
                // このループのattendanceのidを持つrestデータを取得
                // 休憩時間
                $rests = $attendance->rests;
                $total_rest_time = 0;
                foreach ($rests as $rest) {
                    $total_rest_time = $total_rest_time + strtotime($rest->breakout_time) - strtotime($rest->breakin_time);
                }
                $rest_hour = floor($total_rest_time / 3600); // 時を算出
                $rest_minute = floor(($total_rest_time / 60) % 60); // 分を算出
                $rest_seconds = floor($total_rest_time % 60); //秒を算出
                //参考サイト[https://qiita.com/Shouin/items/b4d8d74f2ccba333365b]
                // sprintf関数で第一引数に指定したフォーマットで文字列を生成
                $attendance->rest_time = sprintf('%2d時間%02d分%02d秒', $rest_hour, $rest_minute, $rest_seconds);
                // 拘束時間
                $restraint_time = strtotime($attendance->end_time) - strtotime($attendance->start_time);
                //拘束時間と合計休憩時間の差
                $total_work_time = 0;
                $total_work_time = $total_work_time + $restraint_time - $total_rest_time;
                $work_hour = floor($total_work_time / 3600);
                $work_minute = floor(($total_work_time / 60) % 60);
                $work_second = floor($total_work_time % 60);
                $attendance->work_time = sprintf('%2d時間%02d分%02d秒', $work_hour, $work_minute, $work_second);
            }
        }

        return view('attendance', [
            'attendances' => $attendances,
            'today' => $date
        ]);
    }

    public function changeDate(Request $request)
    {
        // 一日前（'<'ボタン）
        if ($request->input('before') == 'before') {
            $date = date('Y-m-d', strtotime('-1day', strtotime($request->input('date'))));
            $attendances = Attendance::whereDate('date', $date)->orderBy('user_id', 'asc')->paginate(5);
        }
        // 一日後（'>'ボタン）
        if ($request->input('next') == 'next') {
            $date = date('Y-m-d', strtotime('+1day', strtotime($request->input('date'))));
            $attendances = Attendance::whereDate('date', $date)->orderBy('user_id', 'asc')->paginate(5);
        }
        $attendances->appends(compact('date')); //日付を渡す

        foreach ($attendances as $attendance) {
            // このループのattendanceのidを持つrestデータを取得
            // 休憩時間
            $rests = $attendance->rests;
            $total_rest_time = 0;
            foreach ($rests as $rest) {
                $total_rest_time = $total_rest_time + strtotime($rest->breakout_time) - strtotime($rest->breakin_time);
            }
            $rest_hour = floor($total_rest_time / 3600); // 時を算出
            $rest_minute = floor(($total_rest_time / 60) % 60); // 分を算出
            $rest_seconds = floor($total_rest_time % 60); //秒を算出
            // sprintf関数で第一引数に指定したフォーマットで文字列を生成
            $attendance->rest_time = sprintf('%2d時間%02d分%02d秒', $rest_hour, $rest_minute, $rest_seconds);
            // 拘束時間
            $restraint_time = strtotime($attendance->end_time) - strtotime($attendance->start_time);
            //拘束時間と合計休憩時間の差
            $total_work_time = 0;
            $total_work_time = $total_work_time + $restraint_time - $total_rest_time;
            $work_hour = floor($total_work_time / 3600);
            $work_minute = floor(($total_work_time / 60) % 60);
            $work_second = floor($total_work_time % 60);
            $attendance->work_time = sprintf('%2d時間%02d分%02d秒', $work_hour, $work_minute, $work_second);
        }

        return view('attendance')->with([
            'attendances' => $attendances,
            'today' => $date
        ]);
    }
}
