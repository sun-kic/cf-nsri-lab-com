<x-layout>
<x-slot name="body_id">
  <body id="profiles">
</x-slot>
        <div class="MainContents">
    {{-- @auth --}}
      <h2>My account</h2>
      <form method="POST" action="/profile/store">
    @csrf
  <section id="input-mydata">
    <h2>基本データ</h2>
      <div class="section-header">あなたについて</div>
  <div class="input-group">
      <label for="prefecture" class="form-label input-group-text">あなたがお住まいの都道府県を教えてください。</label>
        <select class="form-select form-control" name="prefecture">
            <option value="" selected>都道府県を選択してください</option>
            <option value="北海道">北海道</option>
            <option value="青森県">青森県</option>
            <option value="岩手県">岩手県</option>
            <option value="宮城県">宮城県</option>
            <option value="秋田県">秋田県</option>
            <option value="山形県">山形県</option>
            <option value="福島県">福島県</option>
            <option value="茨城県">茨城県</option>
            <option value="栃木県">栃木県</option>
            <option value="群馬県">群馬県</option>
            <option value="埼玉県">埼玉県</option>
            <option value="千葉県">千葉県</option>
            <option value="東京都">東京都</option>
            <option value="神奈川県">神奈川県</option>
            <option value="新潟県">新潟県</option>
            <option value="富山県">富山県</option>
            <option value="石川県">石川県</option>
            <option value="福井県">福井県</option>
            <option value="山梨県">山梨県</option>
            <option value="長野県">長野県</option>
            <option value="岐阜県">岐阜県</option>
            <option value="静岡県">静岡県</option>
            <option value="愛知県">愛知県</option>
            <option value="三重県">三重県</option>
            <option value="滋賀県">滋賀県</option>
            <option value="京都府">京都府</option>
            <option value="大阪府">大阪府</option>
            <option value="兵庫県">兵庫県</option>
            <option value="奈良県">奈良県</option>
            <option value="和歌山県">和歌山県</option>
            <option value="鳥取県">鳥取県</option>
            <option value="島根県">島根県</option>
            <option value="岡山県">岡山県</option>
            <option value="広島県">広島県</option>
            <option value="山口県">山口県</option>
            <option value="徳島県">徳島県</option>
            <option value="香川県">香川県</option>
            <option value="愛媛県">愛媛県</option>
            <option value="高知県">高知県</option>
            <option value="福岡県">福岡県</option>
            <option value="佐賀県">佐賀県</option>
            <option value="長崎県">長崎県</option>
            <option value="熊本県">熊本県</option>
            <option value="大分県">大分県</option>
            <option value="宮崎県">宮崎県</option>
            <option value="鹿児島県">鹿児島県</option>
            <option value="沖縄県">沖縄県</option>
        </select>
    </div>
  <div class="input-group">
      <label for="sex" class="form-label input-group-text">あなたの性別をお答えください。</label>
      <div class="radio-inline-group">
<div class="three-parts">
        <input class="form-check-input" type="radio" name="sex" id="sex1" value="Male">
        <label for="sex1">男性</label>
      </div>
      <div class="three-parts">
        <input class="form-check-input" type="radio" name="sex" id="sex2" value="Female">
        <label for="sex2">女性</label>
      </div>
      <div class="three-parts">
        <input class="form-check-input" type="radio" name="sex" id="sex3" value="other">
        <label for="sex3">その他</label>
      </div>
    </div>
  </div>
  <div class="input-group">
      <label for="age" class="form-label input-group-text">あなたの年齢をお答えください。</label>
      <select class="form-select form-control" name="age" id="age">
        <option selected>年齢を選択してください</option>
        <option value="20歳未満">20歳未満</option>
        <option value="20～29歳">20～29歳</option>
        <option value="30～39歳">30～39歳</option>
        <option value="40～49歳">40～49歳</option>
        <option value="50～59歳">50～59歳</option>
        <option value="60～64歳">60～64歳</option>
        <option value="65～74歳">65～74歳</option>
        <option value="75歳以上">75歳以上</option>
    </select>
    </div>
    <div class="input-group">
      <label for="house_number" class="form-label input-group-text">世代人数をお答えください。</label>
      <input type="number" min="1" pattern="\d*" class="form-control" name="house_number" value="1">
      <span class="input-group-text">人</span>
    </div>
    </section>
    <div class="section-header">お住まいについて</div>
<section id="input-housedata">

  <div class="input-group">
      <label for="house_type" class="form-label input-group-text">お住まいの建て方をお答えください。</label>
      <div class="radio-inline-group">
      <div class="two-parts">
        <input class="form-check-input" type="radio" name="house_type" id="housetype1" value="戸建">
        <label for="housetype1">戸建</label>
      </div>
      <div class="two-parts">
        <input class="form-check-input" type="radio" name="house_type" id="housetype2" value="集合住宅">
        <label for="housetype2">集合住宅（マンション、アパート、長屋、テラスハウス）</label>
      </div>
    </div>
  </div>
    <div class="input-group">
      <label for="house_build_year" class="form-label input-group-text">お住まいの建築年をお答えください。</label>
      <input type="number" min="1900" pattern="\d*" class="form-control" name="house_build_year" placeholder="1900~2022の整数でお答えください">
      <span class="input-group-text">年</span>
    </div>
    <div class="input-group">
      <label for="house_area" class="form-label input-group-text">お住まいの延床面積をお答えください。</label>
      <input type="number" min="0" pattern="\d*" class="form-control" name="house_area" placeholder="㎡の整数でお答えください">
      <span class="input-group-text">m&sup2;</span>
    </div>
</section>
<section class="submitArea">
  <div class="btnsubmit">
      <button type="submit">更新</button>
    </div>
</section>
  </form>
        </div>
  
  
  </x-layout>