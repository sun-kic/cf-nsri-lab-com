<?php

namespace Database\Seeders;

use App\Models\RenewableFacility;
use Illuminate\Database\Seeder;

class RenewableFacilitySeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['category' => RenewableFacility::CATEGORY_CAFE, 'sort_order' => 0, 'name' => 'エコカフェ白馬', 'intro' => '太陽光発電100%のカフェ', 'address' => '長野県白馬村北城1-2-3'],
            ['category' => RenewableFacility::CATEGORY_CAFE, 'sort_order' => 1, 'name' => 'グリーンコーヒー', 'intro' => '地熱エネルギー活用', 'address' => '長野県白馬村北城2-3-4'],
            ['category' => RenewableFacility::CATEGORY_CAFE, 'sort_order' => 2, 'name' => 'サステナブルカフェ', 'intro' => '風力発電を導入', 'address' => '長野県白馬村北城3-4-5'],
            ['category' => RenewableFacility::CATEGORY_SKI, 'sort_order' => 0, 'name' => '白馬八方尾根スキー場', 'intro' => 'ロッジ屋根に太陽光パネル設置', 'address' => '長野県北安曇郡白馬村八方'],
            ['category' => RenewableFacility::CATEGORY_SKI, 'sort_order' => 1, 'name' => 'つがいけマウンテンリゾート', 'intro' => '雪上車の電動化と再エネ電力調達', 'address' => '長野県北安曇郡白馬村神城'],
            ['category' => RenewableFacility::CATEGORY_SKI, 'sort_order' => 2, 'name' => '白馬コルチナスキー場', 'intro' => 'バイオマス熱利用の温熱設備', 'address' => '長野県北安曇郡白馬村北城'],
            ['category' => RenewableFacility::CATEGORY_ONSEN, 'sort_order' => 0, 'name' => '姫川温泉郷 湯元館', 'intro' => '地熱利用の給湯システム', 'address' => '長野県北安曇郡白馬村神城'],
            ['category' => RenewableFacility::CATEGORY_ONSEN, 'sort_order' => 1, 'name' => '白馬塩の道温泉', 'intro' => '太陽光＋省エネ給湯の複合設備', 'address' => '長野県北安曇郡白馬村大字北城'],
            ['category' => RenewableFacility::CATEGORY_ONSEN, 'sort_order' => 2, 'name' => '森の温泉 りんどう', 'intro' => '木質バイオマスボイラー導入', 'address' => '長野県北安曇郡白馬村エリア'],
            ['category' => RenewableFacility::CATEGORY_HOTEL, 'sort_order' => 0, 'name' => 'エコロッジ白馬', 'intro' => '地熱ヒートポンプによる空調', 'address' => '長野県白馬村北城4-5-6'],
            ['category' => RenewableFacility::CATEGORY_HOTEL, 'sort_order' => 1, 'name' => 'グリーンホテル白馬', 'intro' => '再エネ電力100%プラン契約', 'address' => '長野県白馬村大字神城'],
            ['category' => RenewableFacility::CATEGORY_HOTEL, 'sort_order' => 2, 'name' => 'サステナブルイン八方', 'intro' => '自家消費型太陽光＋蓄電池', 'address' => '長野県北安曇郡白馬村八方'],
        ];

        foreach ($rows as $row) {
            RenewableFacility::create($row);
        }
    }
}
