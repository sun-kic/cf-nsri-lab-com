<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RenewableFacility;
use Illuminate\Http\Request;

class RenewableFacilityController extends Controller
{
    public function index()
    {
        $facilities = RenewableFacility::query()->ordered()->get();

        return view('admin.renewable_facilities.index', [
            'facilities' => $facilities,
            'categoryLabels' => RenewableFacility::categoryLabels(),
        ]);
    }

    public function create()
    {
        return view('admin.renewable_facilities.create', [
            'categoryLabels' => RenewableFacility::categoryLabels(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        RenewableFacility::create($validated);

        return redirect()
            ->route('admin.renewable-facilities.index')
            ->with('message', '施設を登録しました。');
    }

    public function edit(RenewableFacility $renewable_facility)
    {
        return view('admin.renewable_facilities.edit', [
            'facility' => $renewable_facility,
            'categoryLabels' => RenewableFacility::categoryLabels(),
        ]);
    }

    public function update(Request $request, RenewableFacility $renewable_facility)
    {
        $renewable_facility->update($this->validated($request));

        return redirect()
            ->route('admin.renewable-facilities.index')
            ->with('message', '施設を更新しました。');
    }

    public function destroy(RenewableFacility $renewable_facility)
    {
        $renewable_facility->delete();

        return redirect()
            ->route('admin.renewable-facilities.index')
            ->with('message', '施設を削除しました。');
    }

    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'category' => ['required', 'string', 'in:'.implode(',', RenewableFacility::categories())],
            'name' => ['required', 'string', 'max:255'],
            'intro' => ['required', 'string', 'max:2000'],
            'address' => ['required', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
        ], [], [
            'category' => 'カテゴリ',
            'name' => '施設名',
            'intro' => '施設紹介',
            'address' => 'アドレス',
            'sort_order' => '表示順',
        ]);

        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        return $validated;
    }
}
