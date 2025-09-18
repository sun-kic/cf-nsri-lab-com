<x-layout>
<x-slot name="body_id">
  <body id="users">
</x-slot>
        <div class="MainContents" id="entry">
<form method="POST" action="/forgot-password">
    @csrf
  <section class="newEntryArea">
    <h1>Carbon Monitor</h1>
    <div id="mv"></div>
    <h2>パスワードのリセット</h2>
          <dl>
            
            <dt>
    <label for="email" class="form-label">メールアドレス</label></dt>
            <dd>
    <input type="text" class="form-control" name="email" value="">
    </dd>
            
          </dl>
        </section>
   
<section class="submitArea">
  <div class="btnsubmit">
    <button type="submit">送信</button>
  </div>
</section>
</form>
</div>


</x-layout>