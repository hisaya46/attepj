<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class UserListController extends Controller
{
    public function getUserList()
    {
        $lists = User::select('id', 'name')->paginate(50);
        return view('user-list', [
            'lists' => $lists
        ]);
    }

    public function getOneUserAttendance(Request $request, $id)
    {
        //参考サイト:[https://qiita.com/naoya-11/items/3563d7ad6112bc59eabd]
        $lists = User::find($id);
        $name = User::select('name')->where('id', $id)->first();
        // $attendances = Attendance::where('user_id', $id)->paginate(5);

        if ($request->page) {
            $date = $request->date; // 現在指定している日付を取得
        } else {
            $date = Carbon::today()->format("Y-m");
        }
        $dt = Carbon::today();
        $year = $dt->year;
        $month = $dt->month;
        $attendances = Attendance::where('user_id', $id)->where('end_time', '!=', '00:00:00')->whereYear('date', $year)->whereMonth('date', $month)->get();

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

        return view('one-user-attendance', [
            'lists' => $lists,
            'name' => $name,
            'attendances' => $attendances,
            'date' => $date
        ]);
    }

    public function changeMonth(Request $request, $id)
    {
        $lists = User::find($id);
        $name = User::select('name')->where('id', $id)->first();

        // 一日前（'<'ボタン）
        if ($request->input('before') == 'before') {
            $date = date('Y-m', strtotime('-1month', strtotime($request->input('date'))));
            $dt = new Carbon($date);
            $year = $dt->year;
            $month = $dt->month;
            $attendances = Attendance::where('user_id', $id)->where('end_time', '!=', '00:00:00')->whereYear('date', $year)->whereMonth('date', $month)->get();
        }
        // 一日後（'>'ボタン）
        if ($request->input('next') == 'next') {
            $date = date('Y-m', strtotime('+1month', strtotime($request->input('date'))));
            $dt = new Carbon($date);
            $year = $dt->year;
            $month = $dt->month;
            $attendances = Attendance::where('user_id', $id)->where('end_time', '!=', '00:00:00')->whereYear('date', $year)->whereMonth('date', $month)->get();
        }

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

        return view('one-user-attendance')->with([
            'lists' => $lists,
            'name' => $name,
            'attendances' => $attendances,
            'date' => $date,
        ]);
    }
}
