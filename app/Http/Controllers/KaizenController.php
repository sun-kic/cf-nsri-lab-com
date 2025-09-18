<?php

namespace App\Http\Controllers;

use App\Models\Kaizen;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KaizenController extends Controller
{
    //
    public function index(){
        $kaizenItemsRandom = $this->pickRandomKaizenItems(8);

        $userId = auth()->id();
        $kaizen = Kaizen::where('user_id', $userId)->latest()->first();
        if (!is_null($kaizen)){
            $point = $kaizen->kaizen_number;
            $start_date = Carbon::now()->firstOfMonth();
            $end_date = Carbon::today()->addDay();
            $point_month = Kaizen::where('user_id', $userId)
                ->whereBetween('created_at', [$start_date, $end_date])
                ->sum('kaizen_number');

        }else{
            $point = 0;
            $point_month = 0;
        }

        return view('kaizens.create', [
            'kaizen_items_random' => $kaizenItemsRandom,
            'point' => $point,
            'point_month' => $point_month,
        ]);
    }

    public function store(Request $request) {

        $userId = auth()->id();
        $kaizen = Kaizen::where('user_id', $userId)->latest()->first();
        
       
        if (is_null($kaizen) or \Carbon\Carbon::now()->format("Y-m-d")!=$kaizen->created_at->format("Y-m-d")){

            $formFields = $request->all();
            $formFields['user_id'] = $userId;
            $itemsCount = count($formFields['kaizen_items']);
            $formFields['kaizen_number'] = $itemsCount;
            $formFields['kaizen_total'] = is_null($kaizen)
                ? $itemsCount
                : $kaizen->kaizen_total + $itemsCount;
                
            if (array_key_exists("kaizen_items",$formFields)){
                $formFields["kaizen_items"] = implode(",",$formFields["kaizen_items"]);
            }
            
            Kaizen::create($formFields);
            return redirect('/kaizen')->with('message', 'Data updated');
        }else{
            return redirect('/kaizen')->with('message', '本日のポイントが獲得済みです');
        }
    }

    private function kaizenItems(): array
    {
        return [
            "01"=>"昼間はなるべく自然光を利用して仕事をします。",
            "02"=>"家の電球はLEDを使っています。",
            "03"=>"使用しない部屋の電気は消します。",
            "04"=>"仕事では、なるべくデジタルメモを取るようにしています。",
            "05"=>"テレビは見るときだけつけます。",
            "06"=>"マイカップ派です。紙コップ派ではありません。",
            "07"=>"水筒を持ち歩いています。",
            "08"=>"野菜は（熱を通さず）フレッシュなものを食べます。",
            "09"=>"菜食主義です。",
            "10"=>"地元でとれた食べ物を好んで食べます。",
            "11"=>"釣った魚を食べます。（釣りが好き）",
            "12"=>"庭で野菜を育てています。（植物を育てるのが好き）",
            "13"=>"旬の食材を好んで食べます。",
            "14"=>"外食では、注文した食べ物は残さずしっかり食べます。",
            "15"=>"エコバックを持ち歩く派です。",
            "16"=>"領収書は受け取りません。",
            "17"=>"ちょっとした移動は、電車です。",
            "18"=>"タクシーに乗るときは３人以上で乗ります。",
            "19"=>"エレベーター利用より階段を上り下りする方が多い。",
            "20"=>"打合せは、ウェブミーティングを活用します。",
            "21"=>"ゴミは、分別します。",
            "22"=>"友人や同僚と地球環境保護について話します。",
            "23"=>"涼しい時間帯に移動します。",
            "24"=>"暑い季節は、日除けシェイドや植物・緑のカーテン、室内カーテンを設置しています。",
            "25"=>"エアコンと扇風機を併用します。",
            "26"=>"暑い時は薄着、寒い時はたくさん服を着て、エアコン温度を調整します。",
            "27"=>"夏は避暑地に逃げ、冬は南国に逃げます。",
        ];
    }

    private function pickRandomKaizenItems(int $count): array
    {
        $items = $this->kaizenItems();

        if ($count >= count($items)) {
            return $items;
        }

        $selectedKeys = (array) array_rand($items, $count);
        shuffle($selectedKeys);

        $randomised = [];
        foreach ($selectedKeys as $key) {
            $randomised[$key] = $items[$key];
        }

        return $randomised;
    }
}
