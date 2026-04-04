<x-layout>
<x-slot name="body_id">
  <body id="admin-renewable-facilities">
</x-slot>
<div class="MainContents">
  <h2>再エネ施設の管理</h2>
  <p class="mb-3"><a href="{{ route('admin.renewable-facilities.create') }}" class="btn btn-success">新規登録</a></p>

  @if($facilities->isEmpty())
    <p>登録されている施設はありません。「新規登録」から追加してください。</p>
  @else
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
          <tr>
            <th scope="col">表示順</th>
            <th scope="col">カテゴリ</th>
            <th scope="col">施設名</th>
            <th scope="col">施設紹介</th>
            <th scope="col">アドレス</th>
            <th scope="col" style="width: 140px;">操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach($facilities as $facility)
            <tr>
              <td>{{ $facility->sort_order }}</td>
              <td>{{ $categoryLabels[$facility->category] ?? $facility->category }}</td>
              <td>{{ $facility->name }}</td>
              {{-- Str::limit は mbstring 必須のため、mbstring 未導入環境でも動くよう CSS で省略 --}}
              <td class="renewable-admin-ellipsis" title="{{ $facility->intro }}">{{ $facility->intro }}</td>
              <td class="renewable-admin-ellipsis renewable-admin-ellipsis--narrow" title="{{ $facility->address }}">{{ $facility->address }}</td>
              <td>
                <a href="{{ route('admin.renewable-facilities.edit', $facility) }}" class="btn btn-sm btn-primary mb-1">編集</a>
                <form method="POST" action="{{ route('admin.renewable-facilities.destroy', $facility) }}" class="d-inline" onsubmit="return confirm('この施設を削除しますか？');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger">削除</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
<style>
  #admin-renewable-facilities .renewable-admin-ellipsis {
    max-width: 16rem;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    vertical-align: middle;
  }
  #admin-renewable-facilities .renewable-admin-ellipsis--narrow {
    max-width: 12rem;
  }
</style>
</x-layout>
