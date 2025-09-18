<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Today;
use App\Models\Profile;
use App\Models\Carbonsum;
use PhpParser\JsonDecoder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TodayController extends Controller
{
    //
    public function index(){
        //本日のレコードがあるかどうかを確認

        $today = Today::where('user_id', auth()->id())
              ->where('activity_date', Carbon::today()->toDateString())
              ->latest()
              ->first();
        $record = Today::where('user_id', auth()->id())->latest()->first();

        if (is_null($record)){
            return view('todays.create'); //初めての入力用フォーム
        }elseif($today){
            return view('todays.edit',['today' => $today]); //当日のデータアップデート用
        }else{
            return view('todays.index',['today' => $record]); //当日の新規データ入力用
        }
    }

    public function route(Request $request){
        mb_language("Japanese");//文字コードの設定
        mb_internal_encoding("UTF-8");
        $api_key = "AIzaSyAdAzDw1ryIvdAsYQVxFuY4Uw32HWWHf_8";
        $departure = urlencode($_GET["departure"]);
        $arrival = urlencode($_GET["arrival"]);
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin=" . $departure . "&destination=".$arrival. "&key=" . $api_key ;
        $contents= file_get_contents($url);
        $jsonData = json_decode($contents,true);
        if ($jsonData["status"]==="OK"){
            $distance = $jsonData["routes"][0]["legs"][0]["distance"]["value"]/1000;
        }else{
            $distance = 0;
        }
        return $distance;
    }

    public function store(Request $request) {

        $formFields = $request->all();
        $formFields['user_id'] = auth()->id();
        if (array_key_exists("work_office",$formFields)){
            $formFields["work_office"] = implode(",",$formFields["work_office"]);
        }else{
            $formFields["work_office"] = "";
        }
        if (array_key_exists("work_soho",$formFields)){
            $formFields["work_soho"] = implode(",",$formFields["work_soho"]);
        }else{
            $formFields["work_soho"] = "";
        }
        if (array_key_exists("work_3pl",$formFields)){
            $formFields["work_3pl"] = implode(",",$formFields["work_3pl"]);
        }else{
            $formFields["work_3pl"] = "";
        }
        if (array_key_exists("life",$formFields)){
            $formFields["life"] = implode(",",$formFields["life"]);
        }else{
            $formFields["life"] = "";
        }
        if (array_key_exists("move",$formFields)){
            $formFields["move"] = implode(",",$formFields["move"]);
        }else{
            $formFields["move"] = "";
        }
        if (array_key_exists("green_power",$formFields)){
            $formFields["green_power"] = "1";
        }else{
            $formFields["green_power"] = "0";
        }
        if (array_key_exists("light_led_office",$formFields)){
            $formFields["light_led_office"] = "1";
        }else{
            $formFields["light_led_office"] = "0";
        }
        if (array_key_exists("light_led_soho",$formFields)){
            $formFields["light_led_soho"] = "1";
        }else{
            $formFields["light_led_soho"] = "0";
        }
        if (array_key_exists("light_led_3pl",$formFields)){
            $formFields["light_led_3pl"] = "1";
        }else{
            $formFields["light_led_3pl"] = "0";
        }
        if (array_key_exists("move_walk",$formFields)){
            $formFields["move_walk"] = "1";
        }else{
            $formFields["move_walk"] = "0";
        }
        if ($request->hasFile("breakfast_image")){
            $formFields["breakfast_image"] = $request->file("breakfast_image")->store("breakfast",'public');
        }
        if ($request->hasFile("lunch_image")){
            $formFields["lunch_image"] = $request->file("lunch_image")->store("lunch",'public');
        }
        if ($request->hasFile("dinner_image")){
            $formFields["dinner_image"] = $request->file("dinner_image")->store("dinner",'public');
        }

        //計算用の諸データ
        if (array_key_exists("work_office",$formFields)){
            $work_office_time = count(explode(",",$formFields["work_office"]));
        }else{
            $work_office_time = 0;
        }

        if (array_key_exists("work_soho",$formFields)){
            $work_soho_time = count(explode(",",$formFields["work_soho"]));
        }else{
            $work_soho_time = 0;
        }
        
        if (array_key_exists("work_3pl",$formFields)){
            $work_3pl_time = count(explode(",",$formFields["work_3pl"]));
        }else{
            $work_3pl_time = 0;
        }
        
        $works_time = $work_office_time + $work_soho_time + $work_3pl_time; //仕事時間の合計

        if (array_key_exists("life",$formFields)){
            $life_time = count(explode(",",$formFields["life"])); //生活時間の合計
        }else{
            $life_time = 0;
        }

        if (array_key_exists("move",$formFields)){
            $move_time = count(explode(",",$formFields["move"])); //移動時間の合計
        }else{
            $move_time = 0;
        }

        
        

        //電力計算用データ
        if (!is_null($formFields["office_person"])){
            $office_rate = $formFields["office_area"] / $formFields["office_person"];
        }else{
            $office_rate = 1;
        }
        
        $power_company = Profile::where('user_id',auth()->id())->latest()->first()->power_company;
        $power_rate = array(
            '北海道電力ネットワーク(株)'=>0.445,
            '東北電力ネットワーク(株)'=>0.445,
            '東京電力パワーグリッド(株)'=>0.445,
            '中部電力パワーグリッド(株)'=>0.445,
            '北陸電力送配電(株)'=>0.445,
            '関西電力送配電(株)'=>0.445,
            '中国電力ネットワーク(株)'=>0.445,
            '四国電力送配電(株)'=>0.445,
            '九州電力送配電(株)'=>0.445,
            '沖縄電力(株)'=>0.696,
            'その他'=>0.445,
        );
        if(array_key_exists($power_company,$power_rate)){
            $user_power_rate = $power_rate[$power_company];
        }else{
            $user_power_rate = 0.445;
        }  

        //食事計算用データ
        $food_carbon_rate = [
            "定食" => [
                "小盛り" => 150,
                "普通盛り" => 160,
                "大盛り" => 200
            ],
            "丼" => [
                "小盛り" => 200,
                "普通盛り" => 260,
                "大盛り" => 320
            ],
            "麺類" => [
                "小盛り" => 150,
                "普通盛り" => 180,
                "大盛り" => 300
            ],
            "パン" => [
                "小盛り" => 186,
                "普通盛り" => 196,
                "大盛り" => 239
            ]
        ];

        $rice_carbon_rate = [
            "定食" => 1.3,
            "丼" => 1.3,
            "麺類" => 1.7,
            "パン" => 1.3
        ];

        $vegetable_volumn_rate = [
            "定食" => [
                "多い" => 150,
                "普通" => 100,
                "少ない" => 50
            ],
            "丼" => [
                "多い" => 120,
                "普通" => 80,
                "少ない" => 50
            ],
            "麺類" => [
                "多い" => 50,
                "普通" => 30,
                "少ない" => 10
            ],
            "パン" => [
                "多い" => 150,
                "普通" => 100,
                "少ない" => 50
            ]
        ];
        $vegetable_carbon_rate = [
            "トマト" => [
                "冬" => 1.6,
                "春" => 1.6,
                "夏" => 0.6,
                "秋" => 0.6 
            ],
            "きゅうり" => [
                "冬" => 1.7,
                "春" => 1.7,
                "夏" => 0.6,
                "秋" => 0.6
            ],
            "ピーマン" => [
                "冬" => 3.5,
                "春" => 3.5,
                "夏" => 0.7,
                "秋" => 0.7
            ],
            "なす" => [
                "冬" => 1.7,
                "春" => 1.7,
                "夏" => 0.3,
                "秋" => 0.3 
            ],
            "キャベツ" => [
                "冬" => 0.2,
                "春" => 0.2,
                "夏" => 0.3,
                "秋" => 0.3 
            ],
            "ほうれん草" => [
                "冬" => 0.7,
                "春" => 0.7,
                "夏" => 0.7,
                "秋" => 0.7
            ],
            "ねぎ" => [
                "冬" => 0.6,
                "春" => 0.6,
                "夏" => 0.75,
                "秋" => 0.7 
            ],
            "レタス" => [
                "冬" => 0.45,
                "春" => 0.4,
                "夏" => 0.35,
                "秋" => 0.35
            ],
            "白菜" => [
                "冬" => 0.2,
                "春" => 0.2,
                "夏" => 0.25,
                "秋" => 0.2
            ],
            "さといも" => [
                "冬" => 0.4,
                "春" => 0.4,
                "夏" => 0.4,
                "秋" => 0.4
            ],
            "だいこん" => [
                "冬" => 0.2,
                "春" => 0.3,
                "夏" => 0.25,
                "秋" => 0.2
            ],
            "にんじん" => [
                "冬" => 0.3,
                "春" => 0.25,
                "夏" => 0.25,
                "秋" => 0.3
            ],
            "玉ねぎ" => [
                "冬" => 0.3,
                "春" => 0.3,
                "夏" => 0.3,
                "秋" => 0.3
            ],
            "豆類" => [
                "冬" => 1.5,
                "春" => 1.5,
                "夏" => 1.5,
                "秋" => 1.5 
            ],
            "野菜（そのほか）" => [
                "冬" => 0.9,
                "春" => 0.9,
                "夏" => 0.9,
                "秋" => 0.9
            ],

        ];

        $main_carbon_rate = [
            "さんま" => 1,
            "さば" => 0.8,
            "さけ・ます" => 0.7, 
            "ぶり" => 2.3,
            "まぐろ" => 4.3,
            "魚介類（そのほか）" => 3.33,
            "乳製品" => 3.6,
            "卵" => 1.5,
            "鶏肉" => 2.5,
            "豚肉（国産）" => 3.8, 
            "豚肉（輸入）" => 5.3,
            "牛肉（国産）" => 15.2,
            "牛肉（輸入）" => 13.5,
            "肉類（そのほか）" => 8.25
        ];

        $main_volumn_rate = [
            "定食" => [
                "多い" => 150,
                "普通" => 100,
                "少ない" => 50
            ],
            "丼" => [
                "多い" => 120,
                "普通" => 80,
                "少ない" => 50
            ],
            "麺類" => [
                "多い" => 50,
                "普通" => 30,
                "少ない" => 10
            ],
            "パン" => [
                "多い" => 150,
                "普通" => 100,
                "少ない" => 50
            ]
        ];

        $sports_carbon_rate = [
            "散歩" => 0.12015,
            "ジョギング" => 0.12015,
            "筋トレ" => 0.12015, 
            "泳ぐ" => 0.12015,
            "ヨガ" => 0.12015,
            "瞑想" => 0.12015
        ];

        $rest_carbon_rate = [
            "街歩き" => 0,
            "近所の人とおしゃべり" => 0,
            "テレビ" => 0.065, 
            "ゲーム" => 0.016
        ];

        $shopping_carbon_rate = [
            "shopping_ce" => 0.003141,
            "shopping_cloth" => 0.003001,
            "shopping_hobby" => 0.002492, 
            "shopping_office" => 0.005263,
            "shopping_daily" => 0.00303,
            "shopping_tabacco" => 0.001262,
            "shopping_other" => 0.003756
        ];

        if (in_array(\Carbon\Carbon::now()->month, [2,3,4,5])){
            $season = "春";
        }elseif(in_array(\Carbon\Carbon::now()->month, [6,7,8,9])){
            $season = "夏";
        }elseif(in_array(\Carbon\Carbon::now()->month, [10,11,12,1]) ){
            $season = "夏";
        }else{
            $season = "冬";
        }


        //日常生活のデータ抽出（Profileからデータをもらう）
        $life_carbon = Profile::where('user_id',auth()->id())->latest()->first();
        $power_carbon = $life_carbon->power_kw * $user_power_rate / 30;
        $life_carbon->gas_type == "都市ガス" ? $gas_carbon = $life_carbon->gas_m * 2.234 : $gas_carbon = $life_carbon->gas_m * 2.999;
        $kerosine_carbon = $life_carbon->keroine_l * 2.489;
        


        // ワークのカーボン計算
        $formFields["light_led_office"] == 1 ? $light_office_co2 = $formFields["light_time_office"]*15*$office_rate*$user_power_rate*0.5/1000 : $light_office_co2 = $formFields["light_time_office"]*15*$office_rate*$user_power_rate/1000;
        $formFields["light_led_soho"] == 1 ? $light_soho_co2 = $formFields["light_time_soho"]*60*$user_power_rate*0.5/1000 : $light_soho_co2 = $formFields["light_time_soho"]*60*$user_power_rate*0.5/1000;
        $formFields["light_led_3pl"] == 1 ? $light_3pl_co2 = $formFields["light_time_3pl"]*60*$user_power_rate*0.5/1000 : $light_3pl_co2 = $formFields["light_time_3pl"]*60*$user_power_rate*0.5/1000;
        $ac_office_co2 = $formFields["ac_time_office"]*0.14*$office_rate*$user_power_rate;
        $ac_soho_co2 = $formFields["ac_time_soho"]*302*$user_power_rate/1000;
        if (array_key_exists("office_person",$formFields) and array_key_exists("three_pl_type",$formFields)){
            $formFields["three_pl_type"] === "自宅以外の住宅" ? $ac_3pl_co2 = $formFields["ac_time_3pl"]*302*$user_power_rate/1000 : $ac_3pl_co2 = $formFields["ac_time_3pl"]*0.14*2*$user_power_rate;
        }else{
            $ac_3pl_co2 = 0;
        }
        
        $printed_paper_co2 = $formFields["printed_paper"] * 0.017625;
        $pc_co2 = $formFields["pc_time"]*65*$user_power_rate/1000;

        if (array_key_exists("drink_cup_type",$formFields)){
            if ($formFields["drink_cup_type"] === "マイカップ派"){
                $drink_cup_co2 = 0;
            }elseif($formFields["drink_cup_type"] === "紙コップ派"){
                $drink_cup_co2 = 0.054;
            }elseif($formFields["drink_cup_type"] === "ペットボトルや缶購入"){
                $drink_cup_co2 = 0.266;
            }else{
                $drink_cup_co2 = 0;
            }
        }else{
            $drink_cup_co2 = 0;
        }
        

        //ワークのカーボン合計値
        if ($formFields["green_power"] == 1){ //再生可能エネルギーの場合のカーボン消費は0にする
            $works_sum_carbon = 0;
        }else{
            $works_sum_carbon  = $light_office_co2 + $light_soho_co2 + $light_3pl_co2 +$ac_office_co2 + $ac_soho_co2 + $ac_3pl_co2 + $printed_paper_co2 + $pc_co2 + $drink_cup_co2;

        }
        $formFields["works_carbon"] = $works_sum_carbon;

        //生活のカーボン消費計算

        //運動
        if (array_key_exists("sports_place",$formFields) and !is_null($formFields["sports_type"]) and !is_null($formFields["sports_time"])){
            if ($formFields["sports_place"] == "屋外"){
                $sports_carbon = 0;
            }else{
                $sports_carbon = $sports_carbon_rate[$formFields["sports_type"]] * $formFields["sports_time"]; 
            }
        }else{
            $sports_carbon = 0;
        }

        //休み
        if (!is_null($formFields["rest_type"]) and !is_null($formFields["rest_time"])){
            $rest_carbon = $rest_carbon_rate[$formFields["rest_type"]] *0.445 * $formFields["rest_time"]; 
        }else{
            $rest_carbon = 0;
        }

        // //買い物
        // if (!is_null($formFields["shopping_ce"])){
        //     $shopping_ce_carbon = $shopping_carbon_rate["shopping_ce"] * $formFields["shopping_ce"]; 
        // }else{
        //     $shopping_ce_carbon = 0;
        // }
        // if (!is_null($formFields["shopping_cloth"])){
        //     $shopping_cloth = $shopping_carbon_rate["shopping_cloth"] * $formFields["shopping_cloth"]; 
        // }else{
        //     $shopping_cloth = 0;
        // }
        // if (!is_null($formFields["shopping_hobby"])){
        //     $shopping_hobby = $shopping_carbon_rate["shopping_hobby"] * $formFields["shopping_hobby"]; 
        // }else{
        //     $shopping_hobby = 0;
        // }
        // if (!is_null($formFields["shopping_office"])){
        //     $shopping_office = $shopping_carbon_rate["shopping_office"] * $formFields["shopping_office"]; 
        // }else{
        //     $shopping_office = 0;
        // }
        // if (!is_null($formFields["shopping_daily"])){
        //     $shopping_daily = $shopping_carbon_rate["shopping_daily"] * $formFields["shopping_daily"]; 
        // }else{
        //     $shopping_daily = 0;
        // }
        // if (!is_null($formFields["shopping_tabacco"])){
        //     $shopping_tabacco = $shopping_carbon_rate["shopping_tabacco"] * $formFields["shopping_tabacco"]; 
        // }else{
        //     $shopping_tabacco = 0;
        // }
        // if (!is_null($formFields["shopping_other"])){
        //     $shopping_other = $shopping_carbon_rate["shopping_other"] * $formFields["shopping_other"]; 
        // }else{
        //     $shopping_other = 0;
        // }
        // $shopping_carbon_total = $shopping_ce_carbon + $shopping_cloth + $shopping_hobby + $shopping_office + $shopping_daily + $shopping_tabacco + $shopping_other;



        //生活のカーボン合計値
        $life_sum_carbon = ($power_carbon + $gas_carbon + $kerosine_carbon)/30*$life_time/24/$life_carbon->house_number; //月の量を30で割ってから、生活時間の割合をかける
        // $life_sum_carbon = $life_sum_carbon + $sports_carbon + $rest_carbon + $shopping_carbon_total;
        $life_sum_carbon = $life_sum_carbon + $sports_carbon + $rest_carbon;
        $formFields["life_carbon"] = $life_sum_carbon;        


        //食事のカーボン計算
        if (array_key_exists("breakfast_type",$formFields) and array_key_exists("breakfast_vegetable_produced",$formFields) and array_key_exists("breakfast_volumn",$formFields)){
            $breakfast_rice_carbon = $food_carbon_rate[$formFields["breakfast_type"]][$formFields["breakfast_volumn"]] * $rice_carbon_rate[$formFields["breakfast_type"]]/1000;

            if (
                array_key_exists("breakfast_vegetable_type", $formFields) && !empty($formFields["breakfast_vegetable_type"]) &&
                array_key_exists("breakfast_vegetable_volumn", $formFields) && !empty($formFields["breakfast_vegetable_volumn"])
            ) {
                if ($formFields["breakfast_vegetable_produced"] == "地元")
                    $breakfast_vegetable_carbon = $vegetable_carbon_rate[$formFields["breakfast_vegetable_type"]][$season] * $vegetable_volumn_rate[$formFields["breakfast_type"]][$formFields["breakfast_vegetable_volumn"]]/1000*0.9;
                else{
                    $breakfast_vegetable_carbon = $vegetable_carbon_rate[$formFields["breakfast_vegetable_type"]][$season] * $vegetable_volumn_rate[$formFields["breakfast_type"]][$formFields["breakfast_vegetable_volumn"]]/1000;
                }
            }else{
                $breakfast_vegetable_carbon = 0;
            }
            
            if (
                array_key_exists("breakfast_main_type", $formFields) && !empty($formFields["breakfast_main_type"]) &&
                array_key_exists("breakfast_main_volumn", $formFields) && !empty($formFields["breakfast_main_volumn"]) &&
                array_key_exists("breakfast_main_produced", $formFields) && !empty($formFields["breakfast_main_produced"])
            ) {
                if ($formFields["breakfast_main_produced"] == "地元"){
                    $breakfast_main_carbon = $main_carbon_rate[$formFields["breakfast_main_type"]]*$main_volumn_rate[$formFields["breakfast_type"]][$formFields["breakfast_main_volumn"]]/1000*0.9;
                }else{
                    $breakfast_main_carbon = $main_carbon_rate[$formFields["breakfast_main_type"]]*$main_volumn_rate[$formFields["breakfast_type"]][$formFields["breakfast_main_volumn"]]/1000;
                }
            }else{
                $breakfast_main_carbon = 0;
            }
        }else{
            $breakfast_rice_carbon = 0;
            $breakfast_vegetable_carbon = 0;
            $breakfast_main_carbon = 0;
        }

        $breakfast_sum_carbon = $breakfast_rice_carbon + $breakfast_vegetable_carbon + $breakfast_main_carbon;


        if (array_key_exists("lunch_type",$formFields) and array_key_exists("lunch_vegetable_produced",$formFields) and array_key_exists("lunch_volumn",$formFields)){
            $lunch_rice_carbon = $food_carbon_rate[$formFields["lunch_type"]][$formFields["lunch_volumn"]] * $rice_carbon_rate[$formFields["lunch_type"]]/1000;

            if (
                array_key_exists("lunch_vegetable_type", $formFields) && !empty($formFields["lunch_vegetable_type"]) &&
                array_key_exists("lunch_vegetable_volumn", $formFields) && !empty($formFields["lunch_vegetable_volumn"]) &&
                array_key_exists("lunch_vegetable_produced", $formFields) && !empty($formFields["lunch_vegetable_produced"])
            ) {
                if ($formFields["lunch_vegetable_produced"] == "地元")
                    $lunch_vegetable_carbon = $vegetable_carbon_rate[$formFields["lunch_vegetable_type"]][$season] * $vegetable_volumn_rate[$formFields["lunch_type"]][$formFields["lunch_vegetable_volumn"]]/1000*0.9;
                else{
                    $lunch_vegetable_carbon = $vegetable_carbon_rate[$formFields["lunch_vegetable_type"]][$season] * $vegetable_volumn_rate[$formFields["lunch_type"]][$formFields["lunch_vegetable_volumn"]]/1000;
                }
            }else{
                $lunch_vegetable_carbon = 0;
            }

            if (
                array_key_exists("lunch_main_type", $formFields) && !empty($formFields["lunch_main_type"]) &&
                array_key_exists("lunch_main_volumn", $formFields) && !empty($formFields["lunch_main_volumn"]) &&
                array_key_exists("lunch_main_produced", $formFields) && !empty($formFields["lunch_main_produced"])
            ){
                if ($formFields["lunch_main_produced"] == "地元"){
                    $lunch_main_carbon = $main_carbon_rate[$formFields["lunch_main_type"]]*$main_volumn_rate[$formFields["lunch_type"]][$formFields["lunch_main_volumn"]]/1000*0.9;
                }else{
                    $lunch_main_carbon = $main_carbon_rate[$formFields["lunch_main_type"]]*$main_volumn_rate[$formFields["lunch_type"]][$formFields["lunch_main_volumn"]]/1000;
                }
            }else{
                $lunch_main_carbon = 0;
            }
        
        }else{
            $lunch_rice_carbon = 0;
            $lunch_vegetable_carbon = 0;
            $lunch_main_carbon = 0;
        }

        $lunch_sum_carbon = $lunch_rice_carbon + $lunch_vegetable_carbon + $lunch_main_carbon;

        if (array_key_exists("dinner_type",$formFields) and array_key_exists("dinner_vegetable_produced",$formFields) and array_key_exists("dinner_volumn",$formFields)){
            $dinner_rice_carbon = $food_carbon_rate[$formFields["dinner_type"]][$formFields["dinner_volumn"]] * $rice_carbon_rate[$formFields["dinner_type"]]/1000;

            if (
                array_key_exists("dinner_vegetable_type", $formFields) && !empty($formFields["dinner_vegetable_type"]) &&
                array_key_exists("dinner_vegetable_volumn", $formFields) && !empty($formFields["dinner_vegetable_volumn"]) &&
                array_key_exists("dinner_vegetable_produced", $formFields) && !empty($formFields["dinner_vegetable_produced"])
            ) {
                if ($formFields["dinner_vegetable_produced"] == "地元")
                    $dinner_vegetable_carbon = $vegetable_carbon_rate[$formFields["dinner_vegetable_type"]][$season] * $vegetable_volumn_rate[$formFields["dinner_type"]][$formFields["dinner_vegetable_volumn"]]/1000*0.9;
                else{
                    $dinner_vegetable_carbon = $vegetable_carbon_rate[$formFields["dinner_vegetable_type"]][$season] * $vegetable_volumn_rate[$formFields["dinner_type"]][$formFields["dinner_vegetable_volumn"]]/1000;
                }
            }else{
                $dinner_vegetable_carbon = 0;
            }

            if (
                array_key_exists("dinner_main_type", $formFields) && !empty($formFields["dinner_main_type"]) &&
                array_key_exists("dinner_main_volumn", $formFields) && !empty($formFields["dinner_main_volumn"]) &&
                array_key_exists("dinner_main_produced", $formFields) && !empty($formFields["dinner_main_produced"])
            ) {
                if ($formFields["dinner_main_produced"] == "地元"){
                    $dinner_main_carbon = $main_carbon_rate[$formFields["dinner_main_type"]]*$main_volumn_rate[$formFields["dinner_type"]][$formFields["dinner_main_volumn"]]/1000*0.9;
                }else{
                    $dinner_main_carbon = $main_carbon_rate[$formFields["dinner_main_type"]]*$main_volumn_rate[$formFields["dinner_type"]][$formFields["dinner_main_volumn"]]/1000;
                }
            }else{
                $dinner_main_carbon = 0;
            }


        }else{
            $dinner_rice_carbon = 0;
            $dinner_vegetable_carbon = 0;
            $dinner_main_carbon = 0;
        }
        



        $dinner_sum_carbon = $dinner_rice_carbon + $dinner_vegetable_carbon + $dinner_main_carbon;


        //食事のカーボン合計値
        $foods_sum_carbon = $breakfast_sum_carbon + $lunch_sum_carbon + $dinner_sum_carbon;
        $formFields["foods_carbon"] = $foods_sum_carbon;


        //移動のカーボン計算
        mb_language("Japanese");//文字コードの設定
        mb_internal_encoding("UTF-8");
        $api_key = "AIzaSyAdAzDw1ryIvdAsYQVxFuY4Uw32HWWHf_8";
        $move_type_rate = [
            "飛行機" => 0.098,
            "電車" => 0.017,
            "バス" => 0.057,
            "徒歩" => 0,
            "車（タクシー）" => 0.13,
            "自転車" => 0
        ];

        $formFields["move_walk"] == 1 ? $elevator_carbon = 0 : $elevator_carbon = $formFields["move_floor_number"]*0.045*$user_power_rate;

        if (!is_null($formFields["move_out_departure1"]) or !is_null($formFields["move_out_arrival1"]) or !is_null($formFields["move_out_type1"]) or !is_null($formFields["move_out_distance1"])){
            $distance1 = floatval($formFields["move_out_distance1"]);
            $move_out1_carbon = $distance1 * $move_type_rate[$formFields["move_out_type1"]];
        }else{
            $move_out1_carbon = 0;
        }

        if (!is_null($formFields["move_out_departure2"]) or !is_null($formFields["move_out_arrival2"]) or !is_null($formFields["move_out_type2"]) or !is_null($formFields["move_out_distance2"])){
            $distance2 = floatval($formFields["move_out_distance2"]);
            $move_out2_carbon = $distance2 * $move_type_rate[$formFields["move_out_type2"]];
        }else{
            $move_out2_carbon = 0;
        }

        if (!is_null($formFields["move_out_departure3"]) or !is_null($formFields["move_out_arrival3"]) or !is_null($formFields["move_out_type3"]) or !is_null($formFields["move_out_distance3"])){
            $distance3 = floatval($formFields["move_out_distance3"]);
            $move_out3_carbon = $distance3 * $move_type_rate[$formFields["move_out_type3"]];
        }else{
            $move_out3_carbon = 0;
        }

        if (!is_null($formFields["move_out_departure4"]) or !is_null($formFields["move_out_arrival4"]) or !is_null($formFields["move_out_type4"]) or !is_null($formFields["move_out_distance4"])){
            $distance4 = floatval($formFields["move_out_distance4"]);
            $move_out4_carbon = $distance4 * $move_type_rate[$formFields["move_out_type4"]];
        }else{
            $move_out4_carbon = 0;
        }

        // if (!is_null($formFields["move_out_departure1"]) or !is_null($formFields["move_out_arrival1"]) or !is_null($formFields["move_out_type1"])){
        //     $departure1 = urlencode($formFields["move_out_departure1"]);
        //     $arrival1 = urlencode($formFields["move_out_arrival1"]);
        //     $url = "https://maps.googleapis.com/maps/api/directions/json?origin=" . $departure1 . "&destination=".$arrival1. "&key=" . $api_key ;
        //     $contents= file_get_contents($url);
        //     $jsonData = json_decode($contents,true);
        //     if ($jsonData["status"]==="OK"){
        //         $distance1 = $jsonData["routes"][0]["legs"][0]["distance"]["value"] /1000;
        //         $move_out1_carbon = $distance1 * $move_type_rate[$formFields["move_out_type1"]];
        //     }else{
        //         $move_out1_carbon = 0;
        //     }
        // }else{
        //     $move_out1_carbon = 0;
        // }

        // if (!is_null($formFields["move_out_departure2"]) or !is_null($formFields["move_out_arrival2"]) or !is_null($formFields["move_out_type2"])){
        //     $departure2 = urlencode($formFields["move_out_departure2"]);
        //     $arrival2 = urlencode($formFields["move_out_arrival2"]);
        //     $url = "https://maps.googleapis.com/maps/api/directions/json?origin=" . $departure2 . "&destination=".$arrival2. "&key=" . $api_key ;
        //     $contents= file_get_contents($url);
        //     $jsonData = json_decode($contents,true);
        //     if ($jsonData["status"]==="OK"){
        //         $distance2 = $jsonData["routes"][0]["legs"][0]["distance"]["value"]/1000;
        //         $move_out2_carbon = $distance2 * $move_type_rate[$formFields["move_out_type2"]];
        //     }else{
        //         $move_out2_carbon = 0;
        //     }
        // }else{
        //     $move_out2_carbon = 0;
        // }

        // if (!is_null($formFields["move_out_departure3"]) or !is_null($formFields["move_out_arrival3"]) or !is_null($formFields["move_out_type3"])){
        //     $departure3 = urlencode($formFields["move_out_departure3"]);
        //     $arrival3 = urlencode($formFields["move_out_arrival3"]);
        //     $url = "https://maps.googleapis.com/maps/api/directions/json?origin=" . $departure3 . "&destination=".$arrival3. "&key=" . $api_key ;
        //     $contents= file_get_contents($url);
        //     $jsonData = json_decode($contents,true);
        //     if ($jsonData["status"]==="OK"){
        //         $distance3 = $jsonData["routes"][0]["legs"][0]["distance"]["value"]/1000;
        //         $move_out3_carbon = $distance3 * $move_type_rate[$formFields["move_out_type3"]];
        //     }else{
        //         $move_out3_carbon = 0;
        //     }
        // }else{
        //     $move_out3_carbon = 0;
        // }

        // if (!is_null($formFields["move_out_departure4"]) or !is_null($formFields["move_out_arrival4"]) or !is_null($formFields["move_out_type4"])){
        //     $departure4 = urlencode($formFields["move_out_departure4"]);
        //     $arrival4 = urlencode($formFields["move_out_arrival4"]);
        //     $url = "https://maps.googleapis.com/maps/api/directions/json?origin=" . $departure4 . "&destination=".$arrival4. "&key=" . $api_key ;
        //     $contents= file_get_contents($url);
        //     $jsonData = json_decode($contents,true);
        //     if ($jsonData["status"]==="OK"){
        //         $distance4 = $jsonData["routes"][0]["legs"][0]["distance"]["value"]/1000;
        //         $move_out4_carbon = $distance4 * $move_type_rate[$formFields["move_out_type4"]];
        //     }else{
        //         $move_out4_carbon = 0;
        //     }
        // }else{
        //     $move_out4_carbon = 0;
        // }

        //移動のカーボン合計値
        $move_sum_carbon = $elevator_carbon + $move_out1_carbon + $move_out2_carbon + $move_out3_carbon + $move_out4_carbon;
        $formFields["move_carbon"] = $move_sum_carbon;


        //数値の合計
        $carbon_sum_person= $formFields["works_carbon"] + $formFields["foods_carbon"] + $formFields["move_carbon"] + $formFields["life_carbon"];

        //activity_dateを使って、その日のデータがあるかどうかを確認、なければ新規作成、あれば更新
        $today = Today::where('user_id',auth()->id())->where('activity_date',$formFields["activity_date"])->first();

        if (is_null($today)){
            $formFields["user_id"] = auth()->id();
            Today::create($formFields);
        }else{
            $formFields["user_id"] = auth()->id();
            $today->update($formFields);
        }

        //ユーザIDを代入
        $carbonsum_list['user_id'] = auth()->id();

        //カーボン記録から合計を求める

        $totalWorksCarbon = Today::where('user_id', auth()->id())->sum('works_carbon');
        $totalFoodsCarbon = Today::where('user_id', auth()->id())->sum('foods_carbon');
        $totalMoveCarbon = Today::where('user_id', auth()->id())->sum('move_carbon');
        $totalLifeCarbon = Today::where('user_id', auth()->id())->sum('life_carbon');
    
    $carbonsum = Carbonsum::where('user_id',auth()->id())->latest()->first();
    

    //カーボン記録がない場合は新規作成
    if (is_null($carbonsum)) {
        $carbonsum_list["accumulated_works_carbon"] = $works_sum_carbon;
        $carbonsum_list["accumulated_foods_carbon"] = $foods_sum_carbon;
        $carbonsum_list["accumulated_move_carbon"] = $move_sum_carbon;
        $carbonsum_list["accumulated_life_carbon"] = $life_sum_carbon;
        $carbonsum_list["accumulated_total_carbon"] = $carbon_sum_person;
        Carbonsum::create($carbonsum_list);
    } else {
        //カーボン記録がある場合は更新
        $carbonsum_list["accumulated_works_carbon"] = $totalWorksCarbon;
        $carbonsum_list["accumulated_foods_carbon"] = $totalFoodsCarbon;
        $carbonsum_list["accumulated_move_carbon"] = $totalMoveCarbon;
        $carbonsum_list["accumulated_life_carbon"] = $totalLifeCarbon;
        $carbonsum_list["accumulated_total_carbon"] = $totalWorksCarbon + $totalFoodsCarbon + $totalMoveCarbon + $totalLifeCarbon;
        $carbonsum->update($carbonsum_list);
    }

        // $carbonsum = Carbonsum::where('user_id',auth()->id())->latest()->first();

        // $carbonsum_list["activity_date"] = \Carbon\Carbon::now()->format("Y-m-d");
       
        // if (is_null($carbonsum)){
            
        //     $carbonsum_list["accumulated_works_carbon"] = 0+$works_sum_carbon;
        //     $carbonsum_list["accumulated_foods_carbon"] = 0+$foods_sum_carbon;
        //     $carbonsum_list["accumulated_move_carbon"] = 0+$move_sum_carbon;
        //     $carbonsum_list["accumulated_life_carbon"] = 0+$life_sum_carbon;
        //     $carbonsum_list["accumulated_total_carbon"] = 0+$carbon_sum_person;
        //     Carbonsum::create($carbonsum_list);
        // }elseif(\Carbon\Carbon::now()->format("Y-m-d")==$carbonsum->activity_date){
        //     $carbonsum_list["accumulated_works_carbon"] = $carbonsum->accumulated_works_carbon + $works_sum_carbon - $carbonsum->works_carbon;
        //     $carbonsum_list["accumulated_foods_carbon"] = $carbonsum->accumulated_foods_carbon + $foods_sum_carbon - $carbonsum->foods_carbon;
        //     $carbonsum_list["accumulated_move_carbon"] = $carbonsum->accumulated_move_carbon + $move_sum_carbon - $carbonsum->move_carbon;
        //     $carbonsum_list["accumulated_life_carbon"] = $carbonsum->accumulated_life_carbon + $life_sum_carbon - $carbonsum->life_carbon;
        //     $carbonsum_list["accumulated_total_carbon"] = $carbonsum->accumulated_total_carbon + $carbon_sum_person - $carbonsum->works_carbon - $carbonsum->foods_carbon - $carbonsum->move_carbon - $carbonsum->life_carbon;
        //     $carbonsum->update($carbonsum_list);
        // }else{
        //     $carbonsum_list["accumulated_works_carbon"] = $carbonsum->accumulated_works_carbon + $works_sum_carbon;
        //     $carbonsum_list["accumulated_foods_carbon"] = $carbonsum->accumulated_foods_carbon + $foods_sum_carbon;
        //     $carbonsum_list["accumulated_move_carbon"] = $carbonsum->accumulated_move_carbon + $move_sum_carbon;
        //     $carbonsum_list["accumulated_life_carbon"] = $carbonsum->accumulated_life_carbon + $life_sum_carbon;
        //     $carbonsum_list["accumulated_total_carbon"] = $carbonsum->accumulated_total_carbon + $carbon_sum_person;
        //     Carbonsum::create($carbonsum_list);
        // }

        // Today::create($formFields);


        return redirect('/today')->with('message', 'profile updated');
    }

    public function update(Request $request, Today $today) {
        

        $formFields = $request->all();
        
        $formFields['user_id'] = auth()->id();
        if (array_key_exists("work_office",$formFields)){
            $formFields["work_office"] = implode(",",$formFields["work_office"]);
        }else{
            $formFields["work_office"] = "";
        }
        if (array_key_exists("work_soho",$formFields)){
            $formFields["work_soho"] = implode(",",$formFields["work_soho"]);
        }else{
            $formFields["work_soho"] = "";
        }
        if (array_key_exists("work_3pl",$formFields)){
            $formFields["work_3pl"] = implode(",",$formFields["work_3pl"]);
        }else{
            $formFields["work_3pl"] = "";
        }
        if (array_key_exists("life",$formFields)){
            $formFields["life"] = implode(",",$formFields["life"]);
        }else{
            $formFields["life"] = "";
        }
        if (array_key_exists("move",$formFields)){
            $formFields["move"] = implode(",",$formFields["move"]);
        }else{
            $formFields["move"] = "";
        }
        if (array_key_exists("green_power",$formFields)){
            $formFields["green_power"] = "1";
        }else{
            $formFields["green_power"] = "0";
        }
        if (array_key_exists("light_led_office",$formFields)){
            $formFields["light_led_office"] = "1";
        }else{
            $formFields["light_led_office"] = "0";
        }
        if (array_key_exists("light_led_soho",$formFields)){
            $formFields["light_led_soho"] = "1";
        }else{
            $formFields["light_led_soho"] = "0";
        }
        if (array_key_exists("light_led_3pl",$formFields)){
            $formFields["light_led_3pl"] = "1";
        }else{
            $formFields["light_led_3pl"] = "0";
        }
        if (array_key_exists("move_walk",$formFields)){
            $formFields["move_walk"] = "1";
        }else{
            $formFields["move_walk"] = "0";
        }
        if ($request->hasFile("breakfast_image")){
            $formFields["breakfast_image"] = $request->file("breakfast_image")->store("breakfast",'public');
        }
        if ($request->hasFile("lunch_image")){
            $formFields["lunch_image"] = $request->file("lunch_image")->store("lunch",'public');
        }
        if ($request->hasFile("dinner_image")){
            $formFields["dinner_image"] = $request->file("dinner_image")->store("dinner",'public');
        }

        //計算用の諸データ
        if (array_key_exists("work_office",$formFields)){
            $work_office_time = count(explode(",",$formFields["work_office"]));
        }else{
            $work_office_time = 0;
        }

        if (array_key_exists("work_soho",$formFields)){
            $work_soho_time = count(explode(",",$formFields["work_soho"]));
        }else{
            $work_soho_time = 0;
        }
        
        if (array_key_exists("work_3pl",$formFields)){
            $work_3pl_time = count(explode(",",$formFields["work_3pl"]));
        }else{
            $work_3pl_time = 0;
        }
        
        $works_time = $work_office_time + $work_soho_time + $work_3pl_time; //仕事時間の合計

        if (array_key_exists("life",$formFields)){
            $life_time = count(explode(",",$formFields["life"])); //生活時間の合計
        }else{
            $life_time = 0;
        }

        if (array_key_exists("move",$formFields)){
            $move_time = count(explode(",",$formFields["move"])); //移動時間の合計
        }else{
            $move_time = 0;
        }

        //電力計算用データ
        if (!is_null($formFields["office_person"])){
            $office_rate = $formFields["office_area"] / $formFields["office_person"];
        }else{
            $office_rate = 1;
        }
        $power_company = Profile::where('user_id',auth()->id())->latest()->first()->power_company;
        $power_rate = array(
            '北海道電力ネットワーク(株)'=>0.445,
            '東北電力ネットワーク(株)'=>0.445,
            '東京電力パワーグリッド(株)'=>0.445,
            '中部電力パワーグリッド(株)'=>0.445,
            '北陸電力送配電(株)'=>0.445,
            '関西電力送配電(株)'=>0.445,
            '中国電力ネットワーク(株)'=>0.445,
            '四国電力送配電(株)'=>0.445,
            '九州電力送配電(株)'=>0.445,
            '沖縄電力(株)'=>0.696,
            'その他'=>0.445,
        );
        if(array_key_exists($power_company,$power_rate)){
            $user_power_rate = $power_rate[$power_company];
        }else{
            $user_power_rate = 0.445;
        }  

        //食事計算用データ
        $food_carbon_rate = [
            "定食" => [
                "小盛り" => 150,
                "普通盛り" => 160,
                "大盛り" => 200
            ],
            "丼" => [
                "小盛り" => 200,
                "普通盛り" => 260,
                "大盛り" => 320
            ],
            "麺類" => [
                "小盛り" => 150,
                "普通盛り" => 180,
                "大盛り" => 300
            ],
            "パン" => [
                "小盛り" => 186,
                "普通盛り" => 196,
                "大盛り" => 239
            ]
        ];

        $rice_carbon_rate = [
            "定食" => 1.3,
            "丼" => 1.3,
            "麺類" => 1.7,
            "パン" => 1.3
        ];

        $vegetable_volumn_rate = [
            "定食" => [
                "多い" => 150,
                "普通" => 100,
                "少ない" => 50
            ],
            "丼" => [
                "多い" => 120,
                "普通" => 80,
                "少ない" => 50
            ],
            "麺類" => [
                "多い" => 50,
                "普通" => 30,
                "少ない" => 10
            ],
            "パン" => [
                "多い" => 150,
                "普通" => 100,
                "少ない" => 50
            ]
        ];

        $vegetable_carbon_rate = [
            "トマト" => [
                "冬" => 1.6,
                "春" => 1.6,
                "夏" => 0.6,
                "秋" => 0.6 
            ],
            "きゅうり" => [
                "冬" => 1.7,
                "春" => 1.7,
                "夏" => 0.6,
                "秋" => 0.6
            ],
            "ピーマン" => [
                "冬" => 3.5,
                "春" => 3.5,
                "夏" => 0.7,
                "秋" => 0.7
            ],
            "なす" => [
                "冬" => 1.7,
                "春" => 1.7,
                "夏" => 0.3,
                "秋" => 0.3 
            ],
            "キャベツ" => [
                "冬" => 0.2,
                "春" => 0.2,
                "夏" => 0.3,
                "秋" => 0.3 
            ],
            "ほうれん草" => [
                "冬" => 0.7,
                "春" => 0.7,
                "夏" => 0.7,
                "秋" => 0.7
            ],
            "ねぎ" => [
                "冬" => 0.6,
                "春" => 0.6,
                "夏" => 0.75,
                "秋" => 0.7 
            ],
            "レタス" => [
                "冬" => 0.45,
                "春" => 0.4,
                "夏" => 0.35,
                "秋" => 0.35
            ],
            "白菜" => [
                "冬" => 0.2,
                "春" => 0.2,
                "夏" => 0.25,
                "秋" => 0.2
            ],
            "さといも" => [
                "冬" => 0.4,
                "春" => 0.4,
                "夏" => 0.4,
                "秋" => 0.4
            ],
            "だいこん" => [
                "冬" => 0.2,
                "春" => 0.3,
                "夏" => 0.25,
                "秋" => 0.2
            ],
            "にんじん" => [
                "冬" => 0.3,
                "春" => 0.25,
                "夏" => 0.25,
                "秋" => 0.3
            ],
            "玉ねぎ" => [
                "冬" => 0.3,
                "春" => 0.3,
                "夏" => 0.3,
                "秋" => 0.3
            ],
            "豆類" => [
                "冬" => 1.5,
                "春" => 1.5,
                "夏" => 1.5,
                "秋" => 1.5 
            ],
            "野菜（そのほか）" => [
                "冬" => 0.9,
                "春" => 0.9,
                "夏" => 0.9,
                "秋" => 0.9
            ],

        ];

        $main_carbon_rate = [
            "さんま" => 1,
            "さば" => 0.8,
            "さけ・ます" => 0.7, 
            "ぶり" => 2.3,
            "まぐろ" => 4.3,
            "魚介類（そのほか）" => 3.33,
            "乳製品" => 3.6,
            "卵" => 1.5,
            "鶏肉" => 2.5,
            "豚肉（国産）" => 3.8, 
            "豚肉（輸入）" => 5.3,
            "牛肉（国産）" => 15.2,
            "牛肉（輸入）" => 13.5,
            "肉類（そのほか）" => 8.25
        ];

        $main_volumn_rate = [
            "定食" => [
                "多い" => 150,
                "普通" => 100,
                "少ない" => 50
            ],
            "丼" => [
                "多い" => 120,
                "普通" => 80,
                "少ない" => 50
            ],
            "麺類" => [
                "多い" => 50,
                "普通" => 30,
                "少ない" => 10
            ],
            "パン" => [
                "多い" => 150,
                "普通" => 100,
                "少ない" => 50
            ]
        ];

        $sports_carbon_rate = [
            "散歩" => 1.5,
            "ジョギング" => 1.5,
            "筋トレ" => 1.5, 
            "泳ぐ" => 1.5,
            "ヨガ" => 1.5,
            "瞑想" => 1.5
        ];

        $rest_carbon_rate = [
            "街歩き" => 0,
            "近所の人とおしゃべり" => 0,
            "テレビ" => 0.065, 
            "ゲーム" => 0.016
        ];

        $shopping_carbon_rate = [
            "shopping_ce" => 0.003141,
            "shopping_cloth" => 0.003001,
            "shopping_hobby" => 0.002492, 
            "shopping_office" => 0.005263,
            "shopping_daily" => 0.00303,
            "shopping_tabacco" => 0.001262,
            "shopping_other" => 0.003756
        ];

        if (in_array(\Carbon\Carbon::now()->month, [2,3,4,5])){
            $season = "春";
        }elseif(in_array(\Carbon\Carbon::now()->month, [6,7,8,9])){
            $season = "夏";
        }elseif(in_array(\Carbon\Carbon::now()->month, [10,11,12,1]) ){
            $season = "夏";
        }else{
            $season = "冬";
        }


        //日常生活のデータ抽出（Profileからデータをもらう）
        $life_carbon = Profile::where('user_id',auth()->id())->latest()->first();
        $power_carbon = $life_carbon->power_kw * $user_power_rate / 30;
        $life_carbon->gas_type == "都市ガス" ? $gas_carbon = $life_carbon->gas_m * 2.234 : $gas_carbon = $life_carbon->gas_m * 2.999;
        $kerosine_carbon = $life_carbon->keroine_l * 2.489;


        // ワークのカーボン計算
        $formFields["light_led_office"] == 1 ? $light_office_co2 = $formFields["light_time_office"]*15*$office_rate*$user_power_rate*0.5/1000 : $light_office_co2 = $formFields["light_time_office"]*15*$office_rate*$user_power_rate/1000;
        $formFields["light_led_soho"] == 1 ? $light_soho_co2 = $formFields["light_time_soho"]*60*$user_power_rate*0.5/1000 : $light_soho_co2 = $formFields["light_time_soho"]*60*$user_power_rate*0.5/1000;
        $formFields["light_led_3pl"] == 1 ? $light_3pl_co2 = $formFields["light_time_3pl"]*60*$user_power_rate*0.5/1000 : $light_3pl_co2 = $formFields["light_time_soho"]*60*$user_power_rate*0.5/1000;
        $ac_office_co2 = $formFields["ac_time_office"]*0.14*$office_rate*$user_power_rate;
        $ac_soho_co2 = $formFields["ac_time_soho"]*302*$user_power_rate/1000;
        if (array_key_exists("office_person",$formFields) and array_key_exists("three_pl_type",$formFields)){
            $formFields["three_pl_type"] === "自宅以外の住宅" ? $ac_3pl_co2 = $formFields["ac_time_3pl"]*302*$user_power_rate/1000 : $ac_3pl_co2 = $formFields["ac_time_3pl"]*0.14*2*$user_power_rate;
        }else{
            $ac_3pl_co2 = 0;
        }
        
        $printed_paper_co2 = $formFields["printed_paper"] * 0.017625;
        $pc_co2 = $formFields["pc_time"]*65*$user_power_rate/1000;

        if (array_key_exists("drink_cup_type",$formFields)){
            if ($formFields["drink_cup_type"] === "マイカップ派"){
                $drink_cup_co2 = 0;
            }elseif($formFields["drink_cup_type"] === "紙コップ派"){
                $drink_cup_co2 = 0.054;
            }elseif($formFields["drink_cup_type"] === "ペットボトルや缶購入"){
                $drink_cup_co2 = 0.266;
            }else{
                $drink_cup_co2 = 0;
            }
        }else{
            $drink_cup_co2 = 0;
        }
        
        //ワークのカーボン合計値
        if ($formFields["green_power"] == 1){ //再生可能エネルギーの場合のカーボン消費は0にする
            $works_sum_carbon = 0;
        }else{
            $works_sum_carbon  = $light_office_co2 + $light_soho_co2 + $light_3pl_co2 +$ac_office_co2 + $ac_soho_co2 + $ac_3pl_co2 + $printed_paper_co2 + $pc_co2 + $drink_cup_co2;

        }
        $formFields["works_carbon"] = $works_sum_carbon;

        //生活のカーボン消費計算
        if (array_key_exists("sports_place",$formFields) and !is_null($formFields["sports_type"]) and !is_null($formFields["sports_time"])){
            if ($formFields["sports_place"] == "屋外"){
                $sports_carbon = 0;
            }else{
                $sports_carbon = $sports_carbon_rate[$formFields["sports_type"]] *0.445 * $formFields["sports_time"]; 
            }
        }else{
            $sports_carbon = 0;
        }

        if (!is_null($formFields["rest_type"]) and !is_null($formFields["rest_time"])){
            $rest_carbon = $rest_carbon_rate[$formFields["rest_type"]] *0.445 * $formFields["rest_time"]; 
        }else{
            $rest_carbon = 0;
        }

        // if (!is_null($formFields["shopping_ce"])){
        //     $shopping_ce_carbon = $shopping_carbon_rate["shopping_ce"] * $formFields["shopping_ce"]; 
        // }else{
        //     $shopping_ce_carbon = 0;
        // }
        // if (!is_null($formFields["shopping_cloth"])){
        //     $shopping_cloth = $shopping_carbon_rate["shopping_cloth"] * $formFields["shopping_cloth"]; 
        // }else{
        //     $shopping_cloth = 0;
        // }
        // if (!is_null($formFields["shopping_hobby"])){
        //     $shopping_hobby = $shopping_carbon_rate["shopping_hobby"] * $formFields["shopping_hobby"]; 
        // }else{
        //     $shopping_hobby = 0;
        // }
        // if (!is_null($formFields["shopping_office"])){
        //     $shopping_office = $shopping_carbon_rate["shopping_office"] * $formFields["shopping_office"]; 
        // }else{
        //     $shopping_office = 0;
        // }
        // if (!is_null($formFields["shopping_daily"])){
        //     $shopping_daily = $shopping_carbon_rate["shopping_daily"] * $formFields["shopping_daily"]; 
        // }else{
        //     $shopping_daily = 0;
        // }
        // if (!is_null($formFields["shopping_tabacco"])){
        //     $shopping_tabacco = $shopping_carbon_rate["shopping_tabacco"] * $formFields["shopping_tabacco"]; 
        // }else{
        //     $shopping_tabacco = 0;
        // }
        // if (!is_null($formFields["shopping_other"])){
        //     $shopping_other = $shopping_carbon_rate["shopping_other"] * $formFields["shopping_other"]; 
        // }else{
        //     $shopping_other = 0;
        // }
        // $shopping_carbon_total = $shopping_ce_carbon + $shopping_cloth + $shopping_hobby + $shopping_office + $shopping_daily + $shopping_tabacco + $shopping_other;



        //生活のカーボン合計値
        $life_sum_carbon = ($power_carbon + $gas_carbon + $kerosine_carbon)/30*$life_time/24/$life_carbon->house_number; //月の量を30で割ってから、生活時間の割合をかける
        // $life_sum_carbon = $life_sum_carbon + $sports_carbon + $rest_carbon + $shopping_carbon_total;
        $life_sum_carbon = $life_sum_carbon + $sports_carbon + $rest_carbon;
        $formFields["life_carbon"] = $life_sum_carbon;

        


        //食事のカーボン計算
        
        if (array_key_exists("breakfast_type",$formFields) and array_key_exists("breakfast_vegetable_produced",$formFields) and array_key_exists("breakfast_volumn",$formFields)){
            $breakfast_rice_carbon = $food_carbon_rate[$formFields["breakfast_type"]][$formFields["breakfast_volumn"]] * $rice_carbon_rate[$formFields["breakfast_type"]]/1000;
            if (
                array_key_exists("breakfast_vegetable_type", $formFields) && !empty($formFields["breakfast_vegetable_type"]) &&
                array_key_exists("breakfast_vegetable_volumn", $formFields) && !empty($formFields["breakfast_vegetable_volumn"])
            ) {
                if ($formFields["breakfast_vegetable_produced"] == "地元")
                    $breakfast_vegetable_carbon = $vegetable_carbon_rate[$formFields["breakfast_vegetable_type"]][$season] * $vegetable_volumn_rate[$formFields["breakfast_type"]][$formFields["breakfast_vegetable_volumn"]]/1000*0.9;
                else{
                    $breakfast_vegetable_carbon = $vegetable_carbon_rate[$formFields["breakfast_vegetable_type"]][$season] * $vegetable_volumn_rate[$formFields["breakfast_type"]][$formFields["breakfast_vegetable_volumn"]]/1000;
                }
            }else{
                $breakfast_vegetable_carbon = 0;
            }
            
            if (
                array_key_exists("breakfast_main_type", $formFields) && !empty($formFields["breakfast_main_type"]) &&
                array_key_exists("breakfast_main_volumn", $formFields) && !empty($formFields["breakfast_main_volumn"]) &&
                array_key_exists("breakfast_main_produced", $formFields) && !empty($formFields["breakfast_main_produced"])
            ) {
                if ($formFields["breakfast_main_produced"] == "地元"){
                    $breakfast_main_carbon = $main_carbon_rate[$formFields["breakfast_main_type"]]*$main_volumn_rate[$formFields["breakfast_type"]][$formFields["breakfast_main_volumn"]]/1000*0.9;
                }else{
                    $breakfast_main_carbon = $main_carbon_rate[$formFields["breakfast_main_type"]]*$main_volumn_rate[$formFields["breakfast_type"]][$formFields["breakfast_main_volumn"]]/1000;
                }
            }else{
                $breakfast_main_carbon = 0;
            }
        }else{
            $breakfast_rice_carbon = 0;
            $breakfast_vegetable_carbon = 0;
            $breakfast_main_carbon = 0;
        }

        $breakfast_sum_carbon = $breakfast_rice_carbon + $breakfast_vegetable_carbon + $breakfast_main_carbon;


        if (array_key_exists("lunch_type",$formFields) and array_key_exists("lunch_vegetable_produced",$formFields) and array_key_exists("lunch_volumn",$formFields)){
            $lunch_rice_carbon = $food_carbon_rate[$formFields["lunch_type"]][$formFields["lunch_volumn"]] * $rice_carbon_rate[$formFields["lunch_type"]]/1000;

            if (
                array_key_exists("lunch_vegetable_type", $formFields) && !empty($formFields["lunch_vegetable_type"]) &&
                array_key_exists("lunch_vegetable_volumn", $formFields) && !empty($formFields["lunch_vegetable_volumn"]) &&
                array_key_exists("lunch_vegetable_produced", $formFields) && !empty($formFields["lunch_vegetable_produced"])
            ) {
                if ($formFields["lunch_vegetable_produced"] == "地元")
                    $lunch_vegetable_carbon = $vegetable_carbon_rate[$formFields["lunch_vegetable_type"]][$season] * $vegetable_volumn_rate[$formFields["lunch_type"]][$formFields["lunch_vegetable_volumn"]]/1000*0.9;
                else{
                    $lunch_vegetable_carbon = $vegetable_carbon_rate[$formFields["lunch_vegetable_type"]][$season] * $vegetable_volumn_rate[$formFields["lunch_type"]][$formFields["lunch_vegetable_volumn"]]/1000;
                }
            }else{
                $lunch_vegetable_carbon = 0;
            }

            if (
                array_key_exists("lunch_main_type", $formFields) && !empty($formFields["lunch_main_type"]) &&
                array_key_exists("lunch_main_volumn", $formFields) && !empty($formFields["lunch_main_volumn"]) &&
                array_key_exists("lunch_main_produced", $formFields) && !empty($formFields["lunch_main_produced"])
            ){
                if ($formFields["lunch_main_produced"] == "地元"){
                    $lunch_main_carbon = $main_carbon_rate[$formFields["lunch_main_type"]]*$main_volumn_rate[$formFields["lunch_type"]][$formFields["lunch_main_volumn"]]/1000*0.9;
                }else{
                    $lunch_main_carbon = $main_carbon_rate[$formFields["lunch_main_type"]]*$main_volumn_rate[$formFields["lunch_type"]][$formFields["lunch_main_volumn"]]/1000;
                }
            }else{
                $lunch_main_carbon = 0;
            }
        }else{
            $lunch_rice_carbon = 0;
            $lunch_vegetable_carbon = 0;
            $lunch_main_carbon = 0;
        }

        $lunch_sum_carbon = $lunch_rice_carbon + $lunch_vegetable_carbon + $lunch_main_carbon;

        if (array_key_exists("dinner_type",$formFields) and array_key_exists("dinner_vegetable_produced",$formFields) and array_key_exists("dinner_volumn",$formFields)){
            $dinner_rice_carbon = $food_carbon_rate[$formFields["dinner_type"]][$formFields["dinner_volumn"]] * $rice_carbon_rate[$formFields["dinner_type"]]/1000;

            if (
                array_key_exists("dinner_vegetable_type", $formFields) && !empty($formFields["dinner_vegetable_type"]) &&
                array_key_exists("dinner_vegetable_volumn", $formFields) && !empty($formFields["dinner_vegetable_volumn"]) &&
                array_key_exists("dinner_vegetable_produced", $formFields) && !empty($formFields["dinner_vegetable_produced"])
            ) {
                if ($formFields["dinner_vegetable_produced"] == "地元")
                    $dinner_vegetable_carbon = $vegetable_carbon_rate[$formFields["dinner_vegetable_type"]][$season] * $vegetable_volumn_rate[$formFields["dinner_type"]][$formFields["dinner_vegetable_volumn"]]/1000*0.9;
                else{
                    $dinner_vegetable_carbon = $vegetable_carbon_rate[$formFields["dinner_vegetable_type"]][$season] * $vegetable_volumn_rate[$formFields["dinner_type"]][$formFields["dinner_vegetable_volumn"]]/1000;
                }
            }else{
                $dinner_vegetable_carbon = 0;
            }

            if (
                array_key_exists("dinner_main_type", $formFields) && !empty($formFields["dinner_main_type"]) &&
                array_key_exists("dinner_main_volumn", $formFields) && !empty($formFields["dinner_main_volumn"]) &&
                array_key_exists("dinner_main_produced", $formFields) && !empty($formFields["dinner_main_produced"])
            ) {
                if ($formFields["dinner_main_produced"] == "地元"){
                    $dinner_main_carbon = $main_carbon_rate[$formFields["dinner_main_type"]]*$main_volumn_rate[$formFields["dinner_type"]][$formFields["dinner_main_volumn"]]/1000*0.9;
                }else{
                    $dinner_main_carbon = $main_carbon_rate[$formFields["dinner_main_type"]]*$main_volumn_rate[$formFields["dinner_type"]][$formFields["dinner_main_volumn"]]/1000;
                }
            }else{
                $dinner_main_carbon = 0;
            }
        }else{
            $dinner_rice_carbon = 0;
            $dinner_vegetable_carbon = 0;
            $dinner_main_carbon = 0;
        }

        $dinner_sum_carbon = $dinner_rice_carbon + $dinner_vegetable_carbon + $dinner_main_carbon;


        //食事のカーボン合計値
        $foods_sum_carbon = $breakfast_sum_carbon + $lunch_sum_carbon + $dinner_sum_carbon;
        $formFields["foods_carbon"] = $foods_sum_carbon;


        //移動のカーボン計算
        mb_language("Japanese");//文字コードの設定
        mb_internal_encoding("UTF-8");
        $api_key = "AIzaSyAdAzDw1ryIvdAsYQVxFuY4Uw32HWWHf_8";
        $move_type_rate = [
            "飛行機" => 0.098,
            "電車" => 0.017,
            "バス" => 0.057,
            "徒歩" => 0,
            "車（タクシー）" => 0.13,
            "自転車" => 0
        ];

        $formFields["move_walk"] == 1 ? $elevator_carbon = 0 : $elevator_carbon = $formFields["move_floor_number"]*0.045*$user_power_rate;

        if (!is_null($formFields["move_out_departure1"]) or !is_null($formFields["move_out_arrival1"]) or !is_null($formFields["move_out_type1"]) or !is_null($formFields["move_out_distance1"])){
            $distance1 = floatval($formFields["move_out_distance1"]);
            $move_out1_carbon = $distance1 * $move_type_rate[$formFields["move_out_type1"]];
        }else{
            $move_out1_carbon = 0;
        }

        if (!is_null($formFields["move_out_departure2"]) or !is_null($formFields["move_out_arrival2"]) or !is_null($formFields["move_out_type2"]) or !is_null($formFields["move_out_distance2"])){
            $distance2 = floatval($formFields["move_out_distance2"]);
            $move_out2_carbon = $distance2 * $move_type_rate[$formFields["move_out_type2"]];
        }else{
            $move_out2_carbon = 0;
        }

        if (!is_null($formFields["move_out_departure3"]) or !is_null($formFields["move_out_arrival3"]) or !is_null($formFields["move_out_type3"]) or !is_null($formFields["move_out_distance3"])){
            $distance3 = floatval($formFields["move_out_distance3"]);
            $move_out3_carbon = $distance3 * $move_type_rate[$formFields["move_out_type3"]];
        }else{
            $move_out3_carbon = 0;
        }

        if (!is_null($formFields["move_out_departure4"]) or !is_null($formFields["move_out_arrival4"]) or !is_null($formFields["move_out_type4"]) or !is_null($formFields["move_out_distance4"])){
            $distance4 = floatval($formFields["move_out_distance4"]);
            $move_out4_carbon = $distance4 * $move_type_rate[$formFields["move_out_type4"]];
        }else{
            $move_out4_carbon = 0;
        }

        //移動のカーボン合計値
        $move_sum_carbon = $elevator_carbon + $move_out1_carbon + $move_out2_carbon + $move_out3_carbon + $move_out4_carbon;
        $formFields["move_carbon"] = $move_sum_carbon;


        //数値の合計
        $carbon_sum_person= $formFields["works_carbon"] + $formFields["foods_carbon"] + $formFields["move_carbon"] + $formFields["life_carbon"];

        //activity_dateを使って、その日のデータがあるかどうかを確認、なければ新規作成、あれば更新
        $today = Today::where('user_id',auth()->id())->where('activity_date',$formFields["activity_date"])->first();

        if (is_null($today)){
            $formFields["user_id"] = auth()->id();
            Today::create($formFields);
        }else{
            $formFields["user_id"] = auth()->id();
            $today->update($formFields);
        }

        //ユーザIDを代入
        $carbonsum_list['user_id'] = auth()->id();

        //カーボン記録から合計を求める

            $totalWorksCarbon = Today::where('user_id', auth()->id())->sum('works_carbon');
            $totalFoodsCarbon = Today::where('user_id', auth()->id())->sum('foods_carbon');
            $totalMoveCarbon = Today::where('user_id', auth()->id())->sum('move_carbon');
            $totalLifeCarbon = Today::where('user_id', auth()->id())->sum('life_carbon');
        
        $carbonsum = Carbonsum::where('user_id',auth()->id())->latest()->first();
        

        //カーボン記録がない場合は新規作成
        if (is_null($carbonsum)) {
            $carbonsum_list["accumulated_works_carbon"] = $works_sum_carbon;
            $carbonsum_list["accumulated_foods_carbon"] = $foods_sum_carbon;
            $carbonsum_list["accumulated_move_carbon"] = $move_sum_carbon;
            $carbonsum_list["accumulated_life_carbon"] = $life_sum_carbon;
            $carbonsum_list["accumulated_total_carbon"] = $carbon_sum_person;
            Carbonsum::create($carbonsum_list);
        } else {
            //カーボン記録がある場合は更新
            $carbonsum_list["accumulated_works_carbon"] = $totalWorksCarbon;
            $carbonsum_list["accumulated_foods_carbon"] = $totalFoodsCarbon;
            $carbonsum_list["accumulated_move_carbon"] = $totalMoveCarbon;
            $carbonsum_list["accumulated_life_carbon"] = $totalLifeCarbon;
            $carbonsum_list["accumulated_total_carbon"] = $totalWorksCarbon + $totalFoodsCarbon + $totalMoveCarbon + $totalLifeCarbon;
            $carbonsum->update($carbonsum_list);
        }


        // //カーボン記録からデータを取り出す
        // $carbonsum = Carbonsum::where('user_id',auth()->id())->latest()->first();

       
        // if (is_null($carbonsum)){
            
        //     $carbonsum_list["accumulated_works_carbon"] = 0+$works_sum_carbon;
        //     $carbonsum_list["accumulated_foods_carbon"] = 0+$foods_sum_carbon;
        //     $carbonsum_list["accumulated_move_carbon"] = 0+$move_sum_carbon;
        //     $carbonsum_list["accumulated_life_carbon"] = 0+$life_sum_carbon;
        //     $carbonsum_list["accumulated_total_carbon"] = 0+$carbon_sum_person;
        //     Carbonsum::create($carbonsum_list);
        // }elseif(\Carbon\Carbon::now()->format("Y-m-d")==$carbonsum->created_at->format("Y-m-d")){
        //     $carbonsum_list["accumulated_works_carbon"] = $carbonsum->accumulated_works_carbon + $works_sum_carbon - $carbonsum->works_carbon;
        //     $carbonsum_list["accumulated_foods_carbon"] = $carbonsum->accumulated_foods_carbon + $foods_sum_carbon - $carbonsum->foods_carbon;
        //     $carbonsum_list["accumulated_move_carbon"] = $carbonsum->accumulated_move_carbon + $move_sum_carbon - $carbonsum->move_carbon;
        //     $carbonsum_list["accumulated_life_carbon"] = $carbonsum->accumulated_life_carbon + $life_sum_carbon - $carbonsum->life_carbon;
        //     $carbonsum_list["accumulated_total_carbon"] = $carbonsum->accumulated_total_carbon + $carbon_sum_person - $carbonsum->works_carbon - $carbonsum->foods_carbon - $carbonsum->move_carbon - $carbonsum->life_carbon;
        //     $carbonsum->update($carbonsum_list);
        // }else{
        //     $carbonsum_list["accumulated_works_carbon"] = $carbonsum->accumulated_works_carbon + $works_sum_carbon;
        //     $carbonsum_list["accumulated_foods_carbon"] = $carbonsum->accumulated_foods_carbon + $foods_sum_carbon;
        //     $carbonsum_list["accumulated_move_carbon"] = $carbonsum->accumulated_move_carbon + $move_sum_carbon;
        //     $carbonsum_list["accumulated_life_carbon"] = $carbonsum->accumulated_life_carbon + $life_sum_carbon;
        //     $carbonsum_list["accumulated_total_carbon"] = $carbonsum->accumulated_total_carbon + $carbon_sum_person;
        //     Carbonsum::create($carbonsum_list);
        // }

        // $today->update($formFields);

        return back()->with('message', 'diary data updated');
    }
}
