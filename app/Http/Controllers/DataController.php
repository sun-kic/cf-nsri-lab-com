<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Today;
use App\Models\Carbonsum;
use App\Models\Profile;
use Illuminate\Support\Carbon;

class DataController extends Controller
{
    //
    public function index(){

        $sixmonths=Carbon::now()->subMonth(7);
        $energy_consumption_sixmonth = Profile::where('user_id',auth()->id())->whereDate('year_month','>', $sixmonths)->get();
        $user = User::where('id',auth()->id())->first();
        $sevendays=Carbon::today()->subDay(7);
        $carbon_oneweek = Today::where('user_id',auth()->id())->whereDate('created_at','>', $sevendays)->get();

        $power_amount = [];
        $power_kw = [];
        $gas_amount = [];
        $gas_m = [];
        $kerosine_amount = [];
        $kerosine_l = [];

        $work_office = [];
        $work_soho = [];
        $work_3pl = [];
        $life = [];
        $move = [];

        $light_time = [];
        $ac_time = [];
        $printed_paper = [];
        $pc_time = [];
        $drink_cup_type = [];
        $move_floor_number = [];
        $move_out_number = [];
        $breakfast_image = [];
        $lunch_image = [];
        $dinner_image = [];



        foreach ($energy_consumption_sixmonth as $row){
            array_push($power_amount,$row->power_amount);
            array_push($power_kw,$row->power_kw);
            array_push($gas_amount,$row->gas_amount);
            array_push($gas_m,$row->gas_m);
            array_push($kerosine_amount,$row->kerosine_amount);
            array_push($kerosine_l,$row->kerosine_l);
        }
        foreach ($carbon_oneweek as $row){
            array_push($work_office,count(explode(",",$row->work_office)));
            array_push($work_soho,count(explode(",",$row->work_soho)));
            array_push($work_3pl,count(explode(",",$row->work_3pl)));
            array_push($life,count(explode(",",$row->life)));
            array_push($move,count(explode(",",$row->move)));
            array_push($light_time,$row->light_time_office + $row->light_time_soho + $row->light_time_3pl);
            array_push($ac_time,$row->ac_time_office + $row->ac_time_soho + $row->ac_time_3pl);
            array_push($printed_paper,$row->printed_paper);
            array_push($pc_time,$row->pc_time);
            array_push($drink_cup_type,$row->drink_cup_type);
            array_push($move_floor_number,$row->move_floor_number);
            array_push($breakfast_image,$row->breakfast_image);
            array_push($lunch_image,$row->lunch_image);
            array_push($dinner_image,$row->dinner_image);
        }


        return view('data.index',['power_amount' => $power_amount,
                                'power_kw' => $power_kw, 
                                'gas_amount' => $gas_amount, 
                                'gas_m' => $gas_m, 
                                'kerosine_amount' => $kerosine_amount, 
                                'kerosine_l' => $kerosine_l,
                                'work_office' => $work_office, 
                                'work_soho' => $work_soho, 
                                'work_3pl' => $work_3pl, 
                                'life' => $life, 
                                'move' => $move, 
                                'light_time' => $light_time, 
                                'ac_time' => $ac_time, 
                                'printed_paper' => $printed_paper, 
                                'pc_time' => $pc_time, 
                                'drink_cup_type' => $drink_cup_type, 
                                'move_floor_number' => $move_floor_number, 
                                'move_out_number' => $move_out_number, 
                                'breakfast_image' => $breakfast_image, 
                                'lunch_image' => $lunch_image, 
                                'dinner_image' => $dinner_image, 
                                'user'=>$user]);
    }
}
