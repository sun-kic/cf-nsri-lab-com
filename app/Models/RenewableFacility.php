<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenewableFacility extends Model
{
    use HasFactory;

    public const CATEGORY_CAFE = 'cafe';

    public const CATEGORY_SKI = 'ski';

    public const CATEGORY_ONSEN = 'onsen';

    public const CATEGORY_HOTEL = 'hotel';

    protected $fillable = [
        'category',
        'name',
        'intro',
        'address',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public static function categories(): array
    {
        return [
            self::CATEGORY_CAFE,
            self::CATEGORY_SKI,
            self::CATEGORY_ONSEN,
            self::CATEGORY_HOTEL,
        ];
    }

    public static function categoryLabels(): array
    {
        return [
            self::CATEGORY_CAFE => 'カフェ',
            self::CATEGORY_SKI => 'スキーリゾート',
            self::CATEGORY_ONSEN => '温泉施設',
            self::CATEGORY_HOTEL => 'ホテル',
        ];
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * @return array<string, list<array{name: string, intro: string, address: string}>>
     */
    public static function groupedForHome(): array
    {
        $defaults = array_fill_keys(self::categories(), []);
        $facilities = self::query()->ordered()->get();

        foreach ($facilities as $facility) {
            if (! array_key_exists($facility->category, $defaults)) {
                continue;
            }
            $defaults[$facility->category][] = [
                'name' => $facility->name,
                'intro' => $facility->intro,
                'address' => $facility->address,
            ];
        }

        return $defaults;
    }
}
