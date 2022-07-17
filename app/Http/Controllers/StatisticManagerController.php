<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Detail_set_pitchs;
use App\Models\Tickets;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StatisticManagerController extends Controller
{
    public function showChartSetPitch(Request $request){
      $rangeStart =$request->timeStart;
      $rangeEnd =$request->timeEnd;
      $fillter=$request->fillter;
        return view('admin.statistics.chart-set-pitch',compact('rangeStart','rangeEnd','fillter'));
    }
    public function chartSetPitch(Request $request)
    {
       
      $rangeStart =date("Y-m-d", strtotime($request->timeStart));
      $rangeEnd =date("Y-m-d", strtotime($request->timeEnd));
      if(empty($request->timeStart)||empty($request->timeEnd)){
        $rangeStart = Carbon::now()->subDays(7);
        $rangeEnd = Carbon::now()->addDays(0);
      } 
      if($request->fillter==1){
        $stats = Detail_set_pitchs::whereBetween('start_time', [$rangeStart,$rangeEnd])
        ->where('ticket_id',null)
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get([
          Detail_set_pitchs::raw('DATE_FORMAT(start_time, "%d-%m-%Y") as date'),
          Detail_set_pitchs::raw('COUNT(*) as value')
          ])->toJSON();
      } 

      if($request->fillter==30){
        $rangeMonthStart=date("m", strtotime($rangeStart));
        $rangeMonthEnd=date("m",  strtotime($rangeEnd));
        $rangeYearStart=date("Y", strtotime($rangeStart));
        $rangeYearEnd=date("Y",  strtotime($rangeEnd));
        $stats = Detail_set_pitchs::wheremonth('start_time','>=', $rangeMonthStart)->wheremonth('start_time','<=',$rangeMonthEnd)
        ->whereyear('start_time','>=', $rangeYearStart)->whereyear('start_time','<=',$rangeYearEnd)->where('ticket_id',null)
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get([
          Detail_set_pitchs::raw('COUNT(*) as value, DATE_FORMAT(start_time, "%m-%Y") as date')
          ])->toJSON();
      } 
      if($request->fillter==365){
        $rangeStart=date("Y", strtotime($rangeStart));
        $rangeEnd=date("Y",  strtotime($rangeEnd));
        $stats = Detail_set_pitchs::whereyear('start_time','>=', $rangeStart)->whereyear('start_time','<=', $rangeEnd)->where('ticket_id',null)
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get([
          Detail_set_pitchs::raw('COUNT(*) as value, DATE_FORMAT(start_time, "%Y") as date')
          ])->toJSON();
      } 
      
      return $stats;
    }

    public function showChartBillSetPitch(Request $request){
      $rangeStart =$request->timeStart;
      $rangeEnd =$request->timeEnd;
      $fillter=$request->fillter;
        return view('admin.statistics.chart-price-set-pitch',compact('rangeStart','rangeEnd','fillter'));
    }
    public function chartBillSetPitch(Request $request)
    {
      $rangeStart =date("Y-m-d", strtotime($request->timeStart));
      $rangeEnd =date("Y-m-d", strtotime($request->timeEnd));
      if(empty($request->timeStart)||empty($request->timeEnd)){
        $rangeStart = Carbon::now()->subDays(7);
        $rangeEnd = Carbon::now()->addDays(0);
      }  

      if($request->fillter==1){
        $stats = Bill::whereBetween('updated_at', [$rangeStart,$rangeEnd])
        ->where('status',1)
        ->where('detail_set_pitch_id','!=',null)
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get([
          Bill::raw('DATE_FORMAT(updated_at, "%d-%m-%Y")  as date'),
          Bill::raw('sum(price) as value')
          ])->toJSON();  
      } 
  
        if($request->fillter==30){
          $rangeMonthStart=date("m", strtotime($rangeStart));
          $rangeMonthEnd=date("m",  strtotime($rangeEnd));
          $rangeYearStart=date("Y", strtotime($rangeStart));
          $rangeYearEnd=date("Y",  strtotime($rangeEnd));
          $stats = Bill::wheremonth('updated_at','>=', $rangeMonthStart)->wheremonth('updated_at','<=',$rangeMonthEnd)
          ->whereyear('updated_at','>=', $rangeYearStart)->whereyear('updated_at','<=',$rangeYearEnd)
          ->where('status',1)
          ->where('detail_set_pitch_id','!=',null)
          ->groupBy('date')
          ->orderBy('date', 'ASC')
          ->get([
            Bill::raw('sum(price) as value, DATE_FORMAT(updated_at, "%m-%Y") as date'),
            ])->toJSON();
        } 
        if($request->fillter==365){
          $rangeStart=date("Y", strtotime($rangeStart));
          $rangeEnd=date("Y",  strtotime($rangeEnd));
          $stats = Detail_set_pitchs::whereyear('updated_at','>=', $rangeStart)->whereyear('updated_at','<=', $rangeEnd)
          ->where('status',1)
          ->where('detail_set_pitch_id','!=',null)
          ->groupBy('date')
          ->orderBy('date', 'ASC')
          ->get([
            Bill::raw('sum(price) as value, DATE_FORMAT(updated_at, "%Y") as date')
            ])->toJSON();
        } 
      return $stats;
    }
}
