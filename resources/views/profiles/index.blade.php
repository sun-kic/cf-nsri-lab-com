<x-layout>
<x-slot name="body_id">
  <body id="profiles">
</x-slot>
<div class="MainContents">
  {{-- @auth --}}
    <h2>{{$user->name}}'s account</h2>
    <form method="POST" action="/profile/{{$profile->id}}">
  
  @csrf
  @method('PUT')
  <section id="input-mydata">
  <h2>基本データ</h2>
  <div class="section-header">あなたについて</div>
  <div class="input-group">
    <label for="prefecture" class="form-label input-group-text">あなたがお住まいの都道府県を教えてください。</label>
      <select class="form-select form-control" name="prefecture">
          <option value="{{$profile->prefecture}}" selected>{{$profile->prefecture}}</option>
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
      @if ($profile->sex === "Male")
        <input class="form-check-input" type="radio" name="sex" id="sex1" value="Male" checked>   
      @else
        <input class="form-check-input" type="radio" name="sex" id="sex1" value="Male">
      @endif
      <label for="sex1">男性</label>
    </div>
    <div class="three-parts">
      @if ($profile->sex === "Female")
      <input type="radio" name="sex" id="sex2" value="Female" checked>
      @else
      <input type="radio" name="sex" id="sex2" value="Female">
      @endif
      <label for="sex2">女性</label>
    </div>
    <div class="three-parts">
      @if ($profile->sex === "other")
      <input type="radio" name="sex" id="sex3" value="other" checked>
      @else
      <input type="radio" name="sex" id="sex3" value="other">
      @endif
      <label for="sex3">その他</label>
    </div></div>
  </div>

  <div class="input-group">
    <label for="age" class="form-label input-group-text">あなたの年齢をお答えください。</label>
    <select class="form-select form-control" name="age" id="age">
      <option value="{{$profile->age}}" selected>{{$profile->age}}</option>
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
      <input type="number" min="1" pattern="\d*" class="form-control" name="house_number" value={{$profile->house_number}}>
      <span class="input-group-text">人</span>
    </div>
  </section>
  <div class="section-header">
        <h2>お住まいについて</h2>
  </div>
  <section id="input-housedata">
  
  <div class="input-group">
    <label for="house_type" class="form-label input-group-text">お住まいの建て方をお答えください。</label>
                <div class="radio-inline-group">
                    <div class="two-parts">
      @if ($profile->house_type === "戸建")
      <input type="radio" name="house_type" id="housetype1" value="戸建" checked>
      @else
      <input type="radio" name="house_type" id="housetype1" value="戸建">
      @endif
      <label for="housetype1">戸建</label>
    </div>
    <div class="two-parts">
      @if ($profile->house_type === "集合住宅")
      <input type="radio" name="house_type" id="housetype2" value="集合住宅" checked>
      @else
      <input type="radio" name="house_type" id="housetype2" value="集合住宅">
      @endif
      <label for="housetype2">集合住宅<span>（マンション、アパート、長屋、テラスハウス）</span></label>
    </div>
  </div>
  </div>
  
  <div class="input-group">
    <label for="house_build_year" class="form-label input-group-text">お住まいの建築年をお答えください。</label>
    <input type="number" min="1900" pattern="\d*" class="form-control" name="house_build_year" value={{$profile->house_build_year}} >
    <span class="input-group-text">年</span>
  </div>
  
  <div class="input-group">
    <label for="house_area" class="form-label input-group-text">お住まいの延床面積をお答えください。</label>
    <input type="number" min="0" pattern="\d*" class="form-control" name="house_area" value={{$profile->house_area}} >
    <span class="input-group-text">m&sup2;</span>
  </div>
</section>

<h5>{{ \Carbon\Carbon::now()->subMonth()->format("Y年m月") }}のエネルギー消費量を教えてください</h5>
<input type="hidden" class="form-control" name="year_month" value={{\Carbon\Carbon::now()->subMonth()}} >

<section class="powerArea">
  <h3>電気</h3>
<div class="input-group">
  <label for="select_box" class="form-label input-group-text">契約した電力会社</label>
    <select class="form-select form-control" name="power_company" id="select_box">
      @if (is_null($profile->power_company))
      <option selected>契約した電力会社を選択してください</option>
      @else
      <option value="{{$profile->power_company}}" selected>{{$profile->power_company}}</option>
      @endif
      <option value="東京電力パワーグリッド(株)">東京電力パワーグリッド(株)</option>
      <option value="北海道電力ネットワーク(株)">北海道電力ネットワーク(株)</option>
      <option value="東北電力ネットワーク(株)">東北電力ネットワーク(株)</option>
      <option value="中部電力パワーグリッド(株)">中部電力パワーグリッド(株)</option>
      <option value="北陸電力送配電(株)">北陸電力送配電(株)</option>
      <option value="関西電力送配電(株)">関西電力送配電(株)</option>
      <option value="中国電力ネットワーク(株)">中国電力ネットワーク(株)</option>
      <option value="四国電力送配電(株)">四国電力送配電(株)</option>
      <option value="九州電力送配電(株)">九州電力送配電(株)</option>
      <option value="沖縄電力(株)">沖縄電力(株)</option>
      <option value="その他">その他</option>
    </select>
  </div>
  <div class="row">
  {{-- <div class="input-group col">
  <label for="power_amount" class="form-label input-group-text">支払金額</label>
    @if (is_null($profile->power_amount))
    <input type=number min="0" pattern="\d*" class="form-control" name="power_amount" id="power_amount">
    @else
    <input type=number min="0" pattern="\d*" class="form-control" name="power_amount" id="power_amount" value="{{$profile->power_amount}}">
    @endif
    <span class="input-group-text">円</span>
  </div> --}}
  <div class="input-group col">
  <label for="power_kw" class="form-label input-group-text">使用量</label>
    @if (is_null($profile->power_kw))
    <input type=number min="0" pattern="\d*" class="form-control" name="power_kw" id="power_kw">
    @else
    <input type=number min="0" pattern="\d*" class="form-control" name="power_kw" id="power_kw" value="{{$profile->power_kw}}">
    @endif
    <span class="input-group-text">kWh</span>
  </div>
  </div>
</section>
  <section class="gasArea">
  <h3>ガス</h3>
  <div class="input-group">
  <label class="form-label input-group-text" for="gas_type">ガスの種類</label>
                <div class="radio-inline-group">
                    <div class="two-parts">
      @if ($profile->gas_type === "都市ガス")
        <input type="radio" name="gas_type" id="gas_type1" value="都市ガス" checked>
      @else
      <input type="radio" name="gas_type" id="gas_type1" value="都市ガス">
      @endif
      <label for="gas_type1">都市ガス</label>
    </div>
    <div class="two-parts">
      @if ($profile->gas_type === "LPG")
      <input type="radio" name="gas_type" id="gas_type2" value="LPG" checked>
      @else
      <input type="radio" name="gas_type" id="gas_type2" value="LPG">
      @endif
      <label for="gas_type2">LPG</label>
    </div></div>
  </div>
  
  <div class="row">
  {{-- <div class="input-group col">
  <label for="gas_amount" class="form-label input-group-text">ガス料金</label>
    @if (is_null($profile->gas_amount))
    <input type=number min="0" pattern="\d*" class="form-control" name="gas_amount" id="gas_amount">
    @else
    <input type=number min="0" pattern="\d*" class="form-control" name="gas_amount" id="gas_amount" value="{{$profile->gas_amount}}">
    @endif
    <span class="input-group-text">円</span>
  </div> --}}

  <div class="input-group col">
  <label for="gas_m" class="form-label input-group-text">ガス使用量</label>
    @if (is_null($profile->gas_m))
    <input type=number min="0" pattern="\d*" class="form-control" name="gas_m" id="gas_m">
    @else
    <input type=number min="0" pattern="\d*" class="form-control" name="gas_m" id="gas_m" value="{{$profile->gas_m}}">
    @endif
    <span class="input-group-text">m<sup>3</sup></span>
  </div>
  </div>
</section>

<section class="keroseneArea">
  <h3>灯油</h3>
  <div class="row">
  {{-- <div class="input-group col">
    <label for="kerosine_amount" class="input-group-text">灯油料金</label>
    @if (is_null($profile->kerosine_amount))
    <input type=number min="0" pattern="\d*" class="form-control" name="kerosine_amount" id="kerosine_amount">
    @else
    <input type=number min="0" pattern="\d*" class="form-control" name="kerosine_amount" id="kerosine_amount" value="{{$profile->kerosine_amount}}">
    @endif
    <span class="input-group-text">円</span>
  </div> --}}

  <div class="input-group col">
    <label for="kerosine_l" class="input-group-text">灯油使用量</label>
    @if (is_null($profile->kerosine_l))
    <input type=number min="0" pattern="\d*" class="form-control" name="kerosine_l" id="kerosine_l">
    @else
    <input type=number min="0" pattern="\d*" class="form-control" name="kerosine_l" id="kerosine_l" value="{{$profile->kerosine_l}}">
    @endif
    <span class="input-group-text">L</span>
  </div>
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
