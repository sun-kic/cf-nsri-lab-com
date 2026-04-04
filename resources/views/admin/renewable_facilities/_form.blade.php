@php
  /** @var \App\Models\RenewableFacility|null $facility */
  $f = $facility ?? null;
@endphp

<div class="mb-3">
  <label for="category" class="form-label">カテゴリ</label>
  <select name="category" id="category" class="form-select @error('category') is-invalid @enderror" required>
    @foreach($categoryLabels as $key => $label)
      <option value="{{ $key }}" @selected(old('category', $f?->category) === $key)>{{ $label }}</option>
    @endforeach
  </select>
  @error('category')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="mb-3">
  <label for="name" class="form-label">施設名</label>
  <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $f?->name) }}" required maxlength="255">
  @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="mb-3">
  <label for="intro" class="form-label">施設紹介</label>
  <textarea name="intro" id="intro" class="form-control @error('intro') is-invalid @enderror" rows="4" required maxlength="2000">{{ old('intro', $f?->intro) }}</textarea>
  @error('intro')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="mb-3">
  <label for="address" class="form-label">アドレス</label>
  <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $f?->address) }}" required maxlength="500">
  @error('address')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="mb-3">
  <label for="sort_order" class="form-label">表示順（小さいほど上）</label>
  <input type="number" name="sort_order" id="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $f?->sort_order ?? 0) }}" min="0" max="65535">
  @error('sort_order')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
