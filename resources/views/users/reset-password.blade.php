<x-layout>
<x-slot name="body_id">
  <body id="users">
</x-slot>
        <div class="MainContents" id="entry">
<form method="POST" action="/reset-password">
    @csrf
  <section class="newEntryArea">
    <h1>Carbon Monitor</h1>
    <div id="mv"></div>
    <h2>パスワードの再登録</h2>
          <dl>
    <input type="hidden" name="token" value="{{ $token }}">
            <dt>
    <label for="email" class="form-label">メールアドレス</label></dt>
            <dd>
    <input type="text" class="form-control" name="email" value="{{old('email')}}">
    @error('email')
        <p class="alert alert-danger">{{$message}}</p>
    @enderror</dd>
            <dt>
    <label for="password" class="form-label">パスワード</label></dt>
            <dd>
    <input type="password" class="form-control" name="password" value="{{old('password')}}">
    @error('password')
        <p class="alert alert-danger">{{$message}}</p>
    @enderror</dd>
            <dt>
    <label for="password_confirmation" class="form-label">パスワード再入力</label></dt>
            <dd>
    <input type="password" class="form-control" name="password_confirmation" value="{{old('password_confirmation')}}">
    @error('password_confirmation')
        <p class="alert alert-danger">{{$message}}</p>
    @enderror</dd>
          </dl>
        </section>
   
<section class="submitArea">
  <div class="btnsubmit">
    <button type="submit">登録</button>
  </div>
</section>
</form>

</div>


</x-layout>