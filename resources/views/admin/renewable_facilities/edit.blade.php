<x-layout>
<x-slot name="body_id">
  <body id="admin-renewable-facilities-edit">
</x-slot>
<div class="MainContents">
  <h2>再エネ施設 — 編集</h2>
  <p><a href="{{ route('admin.renewable-facilities.index') }}">一覧に戻る</a></p>

  <form method="POST" action="{{ route('admin.renewable-facilities.update', $facility) }}" class="mt-3" style="max-width: 640px;">
    @csrf
    @method('PUT')
    @include('admin.renewable_facilities._form', ['facility' => $facility, 'categoryLabels' => $categoryLabels])
    <button type="submit" class="btn btn-primary">更新する</button>
    <a href="{{ route('admin.renewable-facilities.index') }}" class="btn btn-secondary">キャンセル</a>
  </form>
</div>
</x-layout>
