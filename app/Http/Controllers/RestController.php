<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RestController extends Controller
{
    public function startRest()
    {
        $user = Auth::user();
        $startTime = Attendance::where('start_time', $user->id)->where('date', Carbon::today())->latest()->first();
        $attendance_id = Attendance::find($user->id)->latest()->first();
        $breakin = Rest::where('attendance_id', $attendance_id->id)->latest()->first();

        if (($breakin) && (empty($breakin->breakin_time)) && ($startTime)) {
            return redirect()->back()->with('error', 'すでに休憩開始打刻がされています！');
        };

        $breakin = Rest::create([
            'attendance_id' => $attendance_id->id,
            'breakin_time' => Carbon::now(),
        ]);

        return redirect('/breakout')->with('stampingMessage', '打刻完了！休憩を開始しました！');
    }

    public function endRest()
    {
        $user = Auth::user();
        $attendance_id = Attendance::find($user->id)->latest()->first();
        $breakout = Rest::where('attendance_id', $attendance_id->id)->latest()->first();

        if (!empty($breakout->breakout_time)) {
            return redirect()->back()->with('error', 'すでに休憩終了打刻がされている、もしくは休憩開始打刻がされていません！');
        }

        $breakout->update([
            'breakout_time' => Carbon::now()
        ]);
        return redirect('/breakin')->with('stampingMessage', '打刻完了！休憩を終了しました！');
    }
}
