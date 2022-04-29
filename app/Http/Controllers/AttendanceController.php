<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    //打刻ページ表示
    public function getIndex()
    {
        //ボタン活性非活性
        $workStart = false; //勤務開始ボタン
        $workEnd = false; //勤務終了ボタン
        $breakIn = false; //休憩開始ボタン
        $breakOut = false; //休憩終了ボタン

        $user = Auth::user();
        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now()->format('Y-m-d');
        $attendance = Attendance::where('user_id', $user->id)->where('date', $today)->first();
        $past = Attendance::where('user_id', $user->id)->where('date','<', $today)->first();
        $endTime = Attendance::where('user_id', $user->id)->latest()->first();
        $startTime = Attendance::where('user_id', $user->id)->latest()->first();

        // 出勤したまま日を跨いだ場合、end_timeを'23:59:59'に更新
        if ($past->start_time != null && $past->end_time == null && $past->date != $now) {
            $endTime->update([
                'end_time' => '23:59:59',
            ]);
        }
        // end_timeに'23:59:59'が入ったら、出勤中を継続するため日を跨いだ当日の'start_time'に'00:00:00'を格納する
        // 日を跨いだ時にattendancesテーブルにデータが存在すると処理は実行しない = '00:00:00'を格納する処理は一度だけ行う
        if (($startTime) && $past->end_time == '23:59:59' && empty($attendance)){
            $startTime = Attendance::create([
                'user_id' => $user->id,
                'date' => Carbon::today(),
                'start_time' => '00:00:00',
            ]);
        }

        if ($attendance != null) { // 勤務開始ボタンを押した場合
            if ($attendance['end_time'] != null) { // 勤務終了ボタンを押した場合
            } else { // 勤務中の場合
                $rest = Rest::where('attendance_id', $attendance->id)->latest()->first();
                if ($rest != null) { // 休憩開始ボタンを押した場合
                    if ($rest['breakout_time'] != null) { // 休憩終了ボタンを押した場合
                        $workEnd = true;
                        $breakIn = true;
                    } else { // 休憩中の場合
                        $breakOut = true;
                    }
                } else { // 休憩中ではない場合
                    $workEnd = true;
                    $breakIn = true;
                }
            }
        } else { // 当日初めてログインした場合
            $workStart = true;
        }

        $btn = [
            'workStart' => $workStart,
            'workEnd' => $workEnd,
            'breakIn' => $breakIn,
            'breakOut' => $breakOut,
        ];

        return view('index', ['btn' => $btn]);
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
        //return redirect('/breakin')->with('stampingMessage', '打刻完了！出勤しました！');
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
        //return redirect('/end')->with('stampingMessage', '打刻完了！退勤しました！');
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
                $rest_minute_c = floor(($rest_minute / 5)) * 5; //分を5分単位で切り下げ
                $rest_seconds = floor($total_rest_time % 60); //秒を算出

                //参考サイト:[https://qiita.com/Shouin/items/b4d8d74f2ccba333365b],[https://ichilv.com/php-round/#toc4]
                // sprintf関数で第一引数に指定したフォーマットで文字列を生成
                $attendance->rest_time = sprintf('%2d時間%02d分', $rest_hour, $rest_minute_c, $rest_seconds);
                // 拘束時間
                $restraint_time = strtotime($attendance->end_time) - strtotime($attendance->start_time);
                //拘束時間と合計休憩時間の差
                $total_work_time = 0;
                $total_work_time = $total_work_time + $restraint_time - $total_rest_time;
                $work_hour = floor($total_work_time / 3600);
                $work_minute = floor(($total_work_time / 60) % 60);
                $work_minute_c = floor(($work_minute / 5)) * 5;
                $work_second = floor($total_work_time % 60);
                $attendance->work_time = sprintf('%2d時間%02d分', $work_hour, $work_minute_c, $work_second);
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
            $rest_minute_c = floor(($rest_minute / 5)) * 5; //分を5分単位で切り下げ
            $rest_seconds = floor($total_rest_time % 60); //秒を算出
            $attendance->rest_time = sprintf('%2d時間%02d分', $rest_hour, $rest_minute_c, $rest_seconds);
            // 拘束時間
            $restraint_time = strtotime($attendance->end_time) - strtotime($attendance->start_time);
            //拘束時間と合計休憩時間の差
            $total_work_time = 0;
            $total_work_time = $total_work_time + $restraint_time - $total_rest_time;
            $work_hour = floor($total_work_time / 3600);
            $work_minute = floor(($total_work_time / 60) % 60);
            $work_minute_c = floor(($work_minute / 5)) * 5;
            $work_second = floor($total_work_time % 60);
            $attendance->work_time = sprintf('%2d時間%02d分', $work_hour, $work_minute_c, $work_second);
        }

        return view('attendance')->with([
            'attendances' => $attendances,
            'today' => $date
        ]);
    }
}
