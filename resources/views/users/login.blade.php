<x-layout>
    <div class="MainContents" id="login">
    <form method="POST" action="/users/authenticate">
        @csrf
   <section class="loginArea">
    <h1>Carbon Monitor</h1>
    <div id="mv"></div>
    <h2>LOGIN</h2>
    <dl>
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
    </dl>
    </section><section class="submitArea">
  <div class="btnsubmit">
        <button type="submit">ログイン</button>
  </div>
</section>
    <section class="newEntry">
        <p>
          アカウントお持ちでない方は<br class="sp">まずユーザ登録をしてください。
          <a href="/register">ユーザ登録</a>
        </p>
        <p>
          パスワードが忘れた方<br class="sp">パスワードをリセットしてください。
          <a href="/forgot-password">パスワードリセット</a>
        </p>
        
      </section>
    </form>
    </div>
</x-layout>