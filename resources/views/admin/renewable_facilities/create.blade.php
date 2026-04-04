<x-layout>
<x-slot name="body_id">
  <body id="admin-renewable-facilities-create">
</x-slot>
<div class="MainContents">
  <h2>再エネ施設 — 新規登録</h2>
  <p><a href="{{ route('admin.renewable-facilities.index') }}">一覧に戻る</a></p>

  <form method="POST" action="{{ route('admin.renewable-facilities.store') }}" class="mt-3" style="max-width: 640px;">
    @csrf
    @include('admin.renewable_facilities._form', ['facility' => null, 'categoryLabels' => $categoryLabels])
    <button type="submit" class="btn btn-primary">登録する</button>
    <a href="{{ route('admin.renewable-facilities.index') }}" class="btn btn-secondary">キャンセル</a>
  </form>
</div>
</x-layout>
