<x-layout>
<x-slot name="body_id">
  <body id="todays">
</x-slot>
        <div class="MainContents">
        <form action="/today/store" method="POST" enctype="multipart/form-data">
        <h2>TODAY' Activity</h2>
        <!-- Date input field -->
        <div class="form-group">
            <label for="activity_date">日付を選択:</label>
            <input type="date" id="activity_date" name="activity_date" class="form-control">
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
            const todayJST = new Date(Date.now() + (9 * 60 * 60 * 1000)).toISOString().split('T')[0];
            document.getElementById('activity_date').value = todayJST;
            });
        </script>
          @csrf
            <section class="today-works">
                <div class="scroll">
             <dl>
                <dt class="txtRight">HOUR</dt>
                <dd><div class="time"><span>0</span><span>6</span><span>12</span><span>18</span><span>24</span></div></dd>
                <dt></dt>
                <dd><div class="time-line"><span></span><span></span><span></span></div></dd>
            <dt>ワーク･オフィス</dt>
            <dd class="time-schedule"><div class="btn-group office-work" role="group">
                  @for ($i=0;$i<=23;$i++)
                    <input type="checkbox" name="work_office[]" id="work_office{{$i}}" value="{{$i}}" autocomplete="off">   
                    <label for="work_office{{$i}}">{{$i}}</label>
                  @endfor
                </div></dd>
            <dt>ワーク･在宅勤務</dt>
            <dd class="time-schedule"><div class="btn-group home-work" role="group">
                  @for ($i=0;$i<=23;$i++)
                    <input type="checkbox" name="work_soho[]" id="work_soho{{$i}}" value="{{$i}}" autocomplete="off">   
                    <label for="work_soho{{$i}}">{{$i}}</label>
                  @endfor
                </div></dd>
            <dt>ワーク･サードプレイス</dt>
            <dd class="time-schedule"><div class="btn-group three-pl-work" role="group">
                  @for ($i=0;$i<=23;$i++)
                    <input type="checkbox" name="work_3pl[]" id="work_3pl{{$i}}" value="{{$i}}" autocomplete="off">   
                    <label for="work_3pl{{$i}}">{{$i}}</label>
                  @endfor
                </div></dd>
            <dt>生活</dt>
            <dd class="time-schedule"><div class="btn-group life" role="group">
                  @for ($i=0;$i<=23;$i++)
                    <input type="checkbox" name="life[]" id="life{{$i}}" value="{{$i}}" autocomplete="off">   
                    <label for="life{{$i}}">{{$i}}</label>
                  @endfor
                </div></dd>
            <dt>移動</dt>
            <dd class="time-schedule"><div class="btn-group move" role="group">
                  @for ($i=0;$i<=23;$i++)
                    <input type="checkbox" name="move[]" id="move{{$i}}" value="{{$i}}" autocomplete="off">   
                    <label for="move{{$i}}">{{$i}}</label>
                  @endfor
                </div></dd>
</dl>
                </div>
        </section>
       
        <section class="office-data">
		<h3>仕事の場所について</h3>
		<div class="input-group">
			<span class="input-group-text question">面積</span> <input type="number" pattern="\d*" min="0" class="form-control" name="office_area"> <span class="input-group-text">m&sup2;</span>
		</div>
		<div class="input-group">
			<span class="input-group-text question">在室人数</span> <input class="form-control" min="0" name="office_person" pattern="\d*" type="number"> <span class="input-group-text">人</span>
		</div>
		<div class="input-group">
			<label class="input-group-text question" for="three_pl_type">サードプレイスはどんな場所ですか</label>
			<div class="radio-inline-group">
				<div class="three-parts">
					<input id="three_pl_type0" name="three_pl_type" type="radio" value="サードプレイスに行っていません"> <label for="three_pl_type0">サードプレイスに行っていません</label>
				</div>
				<div class="three-parts">
					<input id="three_pl_type1" name="three_pl_type" type="radio" value="自宅以外の住宅"> <label for="three_pl_type1">自宅以外の住宅</label>
				</div>
				<div class="three-parts">
					<input id="three_pl_type2" name="three_pl_type" type="radio" value="喫茶店やシェアオフィス"> <label for="three_pl_type2">喫茶店やシェアオフィス</label>
				</div>
			</div>
			<div class="input-group">
				<label class="input-group-text question" for="three_pl_type">サードプレイスはお住まいと同じ都市ですか？</label>
				<select class="form-select" id="select_box" name="three_pl_city">
					<option selected value="">
					</option>
					<option value="同じ都市です">
						同じ都市です
					</option>
					<option value="近隣の町">
						近隣の町
					</option>
					<option value="近い観光地">
						近い観光地
					</option>
					<option value="遠い観光地">
						遠い観光地
					</option>
					<option value="海外">
						海外
					</option>
					<option value="その他">
						その他
					</option>
				</select>
			</div>

            <div class="input-group">
                <h4 class="question">再エネやグリーン電力などCO2フリーの電力を使っていますか？</h4>
                <div class="row">
                    <div class="switch-button col">
                        <div class="button">
                            <input id="green_power" name="green_power" type="checkbox" value="1">
                            <div class="knobs">
                                <span>いいえ</span>
                            </div>
                            <div class="layer"></div>
                        </div>
                    </div>
                </div>
            </div>
	</section>

    <section class="work-data">
		<h3>オフィスでの活動について</h3>
		<h4 class="question">部屋の電気をどれぐらい時間をつけて仕事をしましたか</h4>
        
        <div class="row">
		<div class="input-group col">
			<label class="input-group-text" for="light_time_office">オフィス</label> <input class="form-control" id="light_time_office" max="24" min="0" name="light_time_office" pattern="\d*" type="number"> <span class="input-group-text">時間</span>
        </div>
			<div class="switch-button col">
				<label class="input-group-text" for="light_led_office">LEDになっていますか？</label>
				<div class="button">
					<input id="light_led_office" name="light_led_office" type="checkbox" value="1">
					<div class="knobs">
						<span>いいえ</span>
					</div>
					<div class="layer"></div>
				</div>
			</div>
            </div>

            <div class="row">
			<div class="input-group col">
				<label class="input-group-text" for="light_time_soho">在宅勤務</label> <input class="form-control" id="light_time_soho" max="24" min="0" name="light_time_soho" pattern="\d*" type="number"> <span class="input-group-text">時間</span>
            </div>
				<div class="switch-button col">
					<label class="input-group-text" for="light_led_soho">LEDになっていますか？</label>
					<div class="button">
						<input id="light_led_soho" name="light_led_soho" type="checkbox" value="1">
						<div class="knobs">
							<span>いいえ</span>
						</div>
						<div class="layer"></div>
					</div>
				</div>
			</div>

            <div class="row">
			<div class="input-group col">
				<label class="input-group-text" for="light_time_3pl">サードプレイス（その他の場所）</label> <input class="form-control" id="light_time_3pl" max="24" min="0" name="light_time_3pl" pattern="\d*" type="number"> <span class="input-group-text">時間</span>
            </div>
				<div class="switch-button col">
					<label class="input-group-text" for="light_led_3pl">LEDになっていますか？</label>
					<div class="button">
						<input id="light_led_3pl" name="light_led_3pl" type="checkbox" value="1">
						<div class="knobs">
							<span>いいえ</span>
						</div>
						<div class="layer"></div>
					</div>
				</div>
			</div>
			<h4 class="question">仕事中空調をどれぐらいつけていますか？</h4>
            <div class="row">
			<div class="input-group">
				<label class="input-group-text" for="ac_time_office">オフィス</label> <input class="form-control" id="ac_time_office" max="24" min="0" name="ac_time_office" pattern="\d*" type="number"> <span class="input-group-text">時間</span>
			</div>
        </div>
            <div class="row">
			<div class="input-group">
				<label class="input-group-text" for="ac_time_soho">在宅勤務</label> <input class="form-control" id="ac_time_soho" max="24" min="0" name="ac_time_soho" pattern="\d*" type="number"> <label class="input-group-text" for="ac_time_soho">時間</label>
			</div>
        </div>
            <div class="row">
			<div class="input-group">
				<label class="input-group-text" for="ac_time_3pl">サードプレイス</label> <input class="form-control" id="ac_time_3pl" max="24" min="0" name="ac_time_3pl" pattern="\d*" type="number"> <label class="input-group-text" for="ac_time_3pl">時間</label>
			</div>
            </div>
			<div class="input-group">
				<h4 class="question">何枚、プリントアウトやコピーを取りましたか？</h4><input class="form-control" id="printed_paper" name="printed_paper" min="0" pattern="\d*" type="number"> <label class="input-group-text" for="printed_paper">枚</label>
			</div>
			<div class="input-group">
				<h4 class="question">パソコン作業しましたか？</h4><input class="form-control" id="pc_time" name="pc_time" max="24" min="0" pattern="\d*" type="number"><label class="input-group-text" for="pc_time">時間</label>
			</div>
			<div class="input-group">
				<h4 class="question">飲み物は、「マイカップ派」ですか？</h4>
				<div class="radio-inline-group">
					<div class="three-parts">
						<input id="drink_cup_type1" name="drink_cup_type" type="radio" value="マイカップ派"><label for="drink_cup_type1">マイカップ派</label>
					</div>
					<div class="three-parts">
						<input id="drink_cup_type2" name="drink_cup_type" type="radio" value="紙コップ派"><label for="drink_cup_type2">紙コップ派</label>
					</div>
					<div class="three-parts">
						<input id="drink_cup_type3" name="drink_cup_type" type="radio" value="ペットボトルや缶購入"><label for="drink_cup_type3">ペットボトルや缶購入</label>
					</div>
				</div>
			</div>
	</section>
    	<section class="transportation">
		<h3>移動について</h3>
		<div class="row">
			<div class="input-group col">
				<h4 class="question">建物内は何回移動しましたか？</h4><input class="form-control" id="move_floor_number" name="move_floor_number" min="0" pattern="\d*" type="number"><label class="input-group-text" for="move_floor_number">回</label>
			</div>
			<div class="switch-button col">
				<label class="input-group-text" for="light_led_soho">階段を利用しましたか？</label>
				<div class="button">
					<input class="form-check-input" id="move_walk" name="move_walk" type="checkbox">
					<div class="knobs">
						<span>いいえ</span>
					</div>
					<div class="layer"></div>
				</div>
			</div>
		</div>
		<div class="row">
		<div class="input-group">
			<h4 class="question">建物外は何回移動しましたか？</h4><input class="form-control" id="move_out_number" max="4" min="0" name="move_out_number" min="0" pattern="\d*" type="number"><label class="input-group-text" for="light_led_soho">回</label>
		</div></div>
		<div class="input-group">
			<div class="transportation-col">
				<label class="input-group-text" for="move_out_departure1">出発地</label> <input class="form-control" id="move_out_departure1" name="move_out_departure1" type="text">
			</div>
			<div class="transportation-col">
				<label class="input-group-text" for="move_out_arrival1">到着地</label> <input class="form-control" id="move_out_arrival1" name="move_out_arrival1" type="text">
			</div>
            <div class="transportation-col">
                  <button id="move-button1" type="button">距離計算</button>
            </div>
            <div class="transportation-col">
                <label for="move_out_arrival1" class="input-group-text">距離</label>
                  <input type="text" class="form-control" name="move_out_distance1" id="move_out_distance1">
            </div>
			<div class="transportation-col">
				<label class="input-group-text" for="ac_time_office">主な交通手段</label> <select class="form-select" id="move_out_type1" name="move_out_type1">
					<option value="電車">
						電車
					</option>
					<option value="車（タクシー）">
						車（タクシー）
					</option>
					<option value="バス">
						バス
					</option>
					<option value="飛行機">
						飛行機
					</option>
					<option value="自転車">
						自転車
					</option>
					<option value="徒歩">
						徒歩
					</option>
				</select>
			</div>
		</div>
		<div class="input-group border-top_sp">
			<div class="transportation-col">
				<label class="input-group-text" for="move_out_departure2">出発地</label> <input class="form-control" id="move_out_departure2" name="move_out_departure2" type="text">
			</div>
			<div class="transportation-col">
				<label class="input-group-text" for="move_out_arrival2">到着地</label> <input class="form-control" id="move_out_arrival2" name="move_out_arrival2" type="text">
			</div>
            <div class="transportation-col">
                  <button id="move-button2" type="button">距離計算</button>
            </div>
            <div class="transportation-col">
                <label for="move_out_arrival2" class="input-group-text">距離</label>
                  <input type="text" class="form-control" name="move_out_distance2" id="move_out_distance2">
            </div>
			<div class="transportation-col">
				<label class="input-group-text" for="ac_time_office">主な交通手段</label> <select class="form-select" id="move_out_type2" name="move_out_type2">
					<option value="電車">
						電車
					</option>
					<option value="車（タクシー）">
						車（タクシー）
					</option>
					<option value="バス">
						バス
					</option>
					<option value="飛行機">
						飛行機
					</option>
					<option value="自転車">
						自転車
					</option>
					<option value="徒歩">
						徒歩
					</option>
				</select>
			</div>
		</div>
		<div class="input-group border-top_sp">
			<div class="transportation-col">
				<label class="input-group-text" for="move_out_departure3">出発地</label> <input class="form-control" id="move_out_departure3" name="move_out_departure3" type="text">
			</div>
			<div class="transportation-col">
				<label class="input-group-text" for="move_out_arrival3">到着地</label> <input class="form-control" id="move_out_arrival3" name="move_out_arrival3" type="text">
			</div>
            <div class="transportation-col">
                  <button id="move-button3" type="button">距離計算</button>
            </div>
            <div class="transportation-col">
                <label for="move_out_arrival3" class="input-group-text">距離</label>
                  <input type="text" class="form-control" name="move_out_distance3" id="move_out_distance3">
            </div>
			<div class="transportation-col">
				<label class="input-group-text" for="ac_time_office">主な交通手段</label> <select class="form-select" id="move_out_type3" name="move_out_type3">
					<option value="電車">
						電車
					</option>
					<option value="車（タクシー）">
						車（タクシー）
					</option>
					<option value="バス">
						バス
					</option>
					<option value="飛行機">
						飛行機
					</option>
					<option value="自転車">
						自転車
					</option>
					<option value="徒歩">
						徒歩
					</option>
				</select>
			</div>
		</div>
		<div class="input-group border-top_sp">
			<div class="transportation-col">
				<label class="input-group-text" for="move_out_departure4">出発地</label> <input class="form-control" id="move_out_departure4" name="move_out_departure4" type="text">
			</div>
			<div class="transportation-col">
				<label class="input-group-text" for="move_out_arrival4">到着地</label> <input class="form-control" id="move_out_arrival4" name="move_out_arrival4" type="text">
			</div>
            <div class="transportation-col">
                  <button id="move-button4" type="button">距離計算</button>
            </div>
            <div class="transportation-col">
                <label for="move_out_arrival4" class="input-group-text">距離</label>
                  <input type="text" class="form-control" name="move_out_distance4" id="move_out_distance4">
            </div>
			<div class="transportation-col">
				<label class="input-group-text" for="ac_time_office">主な交通手段</label> <select class="form-select" id="move_out_type4" name="move_out_type4">
					<option value="電車">
						電車
					</option>
					<option value="車（タクシー）">
						車（タクシー）
					</option>
					<option value="バス">
						バス
					</option>
					<option value="飛行機">
						飛行機
					</option>
					<option value="自転車">
						自転車
					</option>
					<option value="徒歩">
						徒歩
					</option>
				</select>
			</div>
		</div>
	</section>
         
        <section class="breakfast">
            <h3>朝ご飯について</h3>
            <div class="input-group">
                <label for="breakfast_image" class="input-group-tex question">
                    朝ごはんを撮影しましょう
                </label><div class="upload-img">
                <label for="breakfast_image">
                    朝ごはんを撮影しましょう
                </label>
                    <input type="file" class="form-control" name="breakfast_image" id="breakfast_image">
                    <img id="breakfast_img"><div class="fileclear js-upload-fileclear">選択ファイルをクリア</div>
                    </div>
            </div>
            <div class="input-group">
                <h4 class="question">朝ご飯は外食ですか？</h4>
                <div class="radio-inline-group">
                    <div class="two-parts">
                    <input  type="radio" name="breakfast_place" id="breakfast_place1" value="自炊"><label for="breakfast_place1">自炊</label>
                </div>
                    <div class="two-parts">
                    <input  type="radio" name="breakfast_place" id="breakfast_place2" value="外食"><label for="breakfast_place2">外食</label>
                </div>
                </div>
            </div>
            <div class="input-group">
                <h4 class="question">ご飯の種類は何ですか？</h4>
                <div class="radio-inline-group">
                    <div class="four-parts">
                        <input  type="radio" name="breakfast_type" id="breakfast_type1" value="定食"><label for="breakfast_type1">定食</label>
                    </div>
                    <div class="four-parts">
                        <input  type="radio" name="breakfast_type" id="breakfast_type2" value="丼"><label for="breakfast_type2">丼</label>
                    </div>
                    <div class="four-parts">
                        <input  type="radio" name="breakfast_type" id="breakfast_type3" value="麺類"><label for="breakfast_type3">麺類</label>
                    </div>
                    <div class="four-parts">
                        <input  type="radio" name="breakfast_type" id="breakfast_type4" value="パン"><label for="breakfast_type4">パン</label>
                    </div>
                </div>
            </div>
            <div class="input-group">
                <h4 class="question">量はいつもに比べて</h4>
                <div class="radio-inline-group">
                    <div class="three-parts">
                    <input  type="radio" name="breakfast_volumn" id="breakfast_volumn1" value="小盛り"><label for="breakfast_volumn1">小盛り</label>
                </div><div class="three-parts">
                    <input  type="radio" name="breakfast_volumn" id="breakfast_volumn2" value="普通盛り"><label for="breakfast_volumn2">普通盛り</label>
                </div><div class="three-parts">
                    <input  type="radio" name="breakfast_volumn" id="breakfast_volumn3" value="大盛り"><label for="breakfast_volumn3">大盛り</label>
                </div>
                </div>
            </div>
            <div class="input-group">
                <h4 class="question">野菜の分量は</h4>
                <div class="radio-inline-group">
                    <div class="three-parts">
                    <input  type="radio" name="breakfast_vegetable_volumn" id="breakfast_vegetable_volumn1" value="少ない"><label for="breakfast_vegetable_volumn1">少ない</label>
                </div>
                    <div class="three-parts">
                    <input  type="radio" name="breakfast_vegetable_volumn" id="breakfast_vegetable_volumn2" value="普通"><label for="breakfast_vegetable_volumn2">普通</label>
                </div><div class="three-parts">
                    <input  type="radio" name="breakfast_vegetable_volumn" id="breakfast_vegetable_volumn3" value="多い"><label for="breakfast_vegetable_volumn3">多い</label>
                </div>
                    
                </div>
            </div>
            <div class="input-group">
                <h4 class="question">野菜は何がメインですか？</h4>
                    <select class="form-select" name="breakfast_vegetable_type">
                      <option selected></option>
                      <option value="トマト">トマト</option>
                      <option value="きゅうり">きゅうり</option>
                      <option value="ピーマン">ピーマン</option>
                      <option value="なす">なす</option>
                      <option value="キャベツ">キャベツ</option>
                      <option value="ほうれん草">ほうれん草</option>
                      <option value="ねぎ">ねぎ</option>
                      <option value="レタス">レタス</option>
                      <option value="白菜">白菜</option>
                      <option value="さといも">さといも</option>
                      <option value="だいこん">だいこん</option>
                      <option value="にんじん">にんじん</option>
                      <option value="玉ねぎ">玉ねぎ</option>
                      <option value="豆類">豆類</option>
                      <option value="野菜（そのほか）">野菜（そのほか）</option>
                    </select>
            </div>
            <div class="input-group">
                <h4 class="question">野菜の産地は</h4>
                <div class="radio-inline-group">
                    <div class="four-parts">
                    <input  type="radio" name="breakfast_vegetable_produced" id="breakfast_vegetable_produced1" value="地元"><label for="breakfast_vegetable_produced1">地元</label>
                </div>
                    <div class="four-parts">
                    <input  type="radio" name="breakfast_vegetable_produced" id="breakfast_vegetable_produced2" value="国産"><label for="breakfast_vegetable_produced2">国産</label>
                </div>
                    <div class="four-parts">
                    <input  type="radio" name="breakfast_vegetable_produced" id="breakfast_vegetable_produced3" value="輸入"><label for="breakfast_vegetable_produced3">輸入</label>
                </div>
                    <div class="four-parts">
                    <input  type="radio" name="breakfast_vegetable_produced" id="breakfast_vegetable_produced4" value="わかりません"><label for="breakfast_vegetable_produced4">不明</label>
                </div>
                </div>
            </div>
            <div class="input-group">
                <h4 class="question">主菜の分量は</h4>
                <div class="radio-inline-group">
                    <div class="three-parts">
                    <input  type="radio" name="breakfast_main_volumn" id="breakfast_main_volumn1" value="少ない"><label for="breakfast_main_volumn1">少ない</label>
                </div>
                    <div class="three-parts">
                    <input  type="radio" name="breakfast_main_volumn" id="breakfast_main_volumn2" value="普通"><label for="breakfast_main_volumn2">普通</label>
                </div><div class="three-parts">
                    <input  type="radio" name="breakfast_main_volumn" id="breakfast_main_volumn3" value="多い"><label for="breakfast_main_volumn3">多い</label>
                </div>
                    
                </div>
            </div>
            <div class="input-group">
                <h4 class="question">主菜は何がメインですか？</h4>
                    <select class="form-select" name="breakfast_main_type">
                      <option selected></option>
                      <option value="さんま">さんま</option>
                      <option value="さば">さば</option>
                      <option value="さけ・ます">さけ・ます</option>
                      <option value="ぶり">ぶり</option>
                      <option value="まぐろ">まぐろ</option>
                      <option value="魚介類（そのほか）">魚介類（そのほか）</option>
                      <option value="乳製品">乳製品</option>
                      <option value="卵">卵</option>
                      <option value="鶏肉">鶏肉</option>
                      <option value="豚肉（国産）">豚肉（国産）</option>
                      <option value="豚肉（輸入）">豚肉（輸入）</option>
                      <option value="牛肉（国産）">牛肉（国産）</option>
                      <option value="牛肉（輸入）">牛肉（輸入）</option>
                      <option value="肉類（そのほか）">肉類（そのほか）</option>
                    </select>
            </div>
            <div class="input-group">
                <h4 class="question">主菜の産地は</h4>
                <div class="radio-inline-group">
                    <div class="four-parts">
                    <input  type="radio" name="breakfast_main_produced" id="breakfast_main_produced1" value="地元"><label for="breakfast_main_produced1">地元</label>
                </div>
                    <div class="four-parts">
                    <input  type="radio" name="breakfast_main_produced" id="breakfast_main_produced2" value="国産"><label for="breakfast_main_produced2">国産</label>
                </div>
                    <div class="four-parts">
                    <input  type="radio" name="breakfast_main_produced" id="breakfast_main_produced3" value="輸入"><label for="breakfast_main_produced3">輸入</label>
                </div>
                    <div class="four-parts">
                    <input  type="radio" name="breakfast_main_produced" id="breakfast_main_produced4" value="わかりません"><label for="breakfast_main_produced4">不明</label>
                </div>
            </div>
            </div>
  
        </section>
        <section class="lunch">
            <h3>昼ご飯について</h3>
            <div class="input-group">
                <label for="lunch_image" class="input-group-text question">
                    昼ごはんを撮影しましょう
                </label><div class="upload-img">
                <label for="lunch_image">
                    昼ごはんを撮影しましょう
                </label>
                    <input type="file" class="form-control" name="lunch_image" id="lunch_image">                    
                    <img id="lunch_img"><div class="fileclear js-upload-fileclear">選択ファイルをクリア</div></div>
            </div>
            <div class="input-group">
                <h4 class="question">昼ご飯は外食ですか？</h4>
                <div class="radio-inline-group">
                    <div class="two-parts">
                    <input type="radio" name="lunch_place" id="lunch_place1" value="自炊"><label for="lunch_place1">自炊</label>
                </div>
                    <div class="two-parts">
                    <input type="radio" name="lunch_place" id="lunch_place2" value="外食"><label for="lunch_place2">外食</label>
                </div>
                </div>
            </div>
            <div class="input-group">
                <h4 class="question">ご飯の種類は何ですか？</h4>
                <div class="radio-inline-group">
                    <div class="four-parts">
                        <input type="radio" name="lunch_type" id="lunch_type1" value="定食"><label for="lunch_type1">定食</label>
                    </div>
                    <div class="four-parts">
                        <input type="radio" name="lunch_type" id="lunch_type2" value="丼"><label for="lunch_type2">丼</label>
                        </div>
                    <div class="four-parts">
                        <input type="radio" name="lunch_type" id="lunch_type3" value="麺類"><label for="lunch_type3">麺類</label>
                        </div>
                    <div class="four-parts">
                        <input type="radio" name="lunch_type" id="lunch_type4" value="パン"><label for="lunch_type4">パン</label>
                    </div>
                </div>
            </div>
            <div class="input-group">
                <h4 class="question">量はいつもに比べて</h4>
                <div class="radio-inline-group">
                    <div class="three-parts">
                    <input type="radio" name="lunch_volumn" id="lunch_volumn1" value="小盛り"><label for="lunch_volumn1">小盛り</label>
                </div><div class="three-parts">
                    <input type="radio" name="lunch_volumn" id="lunch_volumn2" value="普通盛り"><label for="lunch_volumn2">普通盛り</label>
                </div>
                    <div class="three-parts">
                    <input type="radio" name="lunch_volumn" id="lunch_volumn3" value="大盛り"><label for="lunch_volumn3">大盛り</label>
                </div>
                    
                </div>
            </div>
            <div class="input-group">
                <h4 class="question">野菜の分量は</h4>
                <div class="radio-inline-group">
                    
                    <div class="three-parts">
                    <input type="radio" name="lunch_vegetable_volumn" id="lunch_vegetable_volumn1" value="少ない"><label for="lunch_vegetable_volumn1">少ない</label>
                </div><div class="three-parts">
                    <input type="radio" name="lunch_vegetable_volumn" id="lunch_vegetable_volumn2" value="普通"><label for="lunch_vegetable_volumn2">普通</label>
                </div><div class="three-parts">
                    <input type="radio" name="lunch_vegetable_volumn" id="lunch_vegetable_volumn3" value="多い"><label for="lunch_vegetable_volumn3">多い</label>
                </div>
                    
                </div>
            </div>
            <div class="input-group">
                <h4 class="question">野菜は何がメインですか？</h4>
                    <select class="form-select" name="lunch_vegetable_type">
                      <option selected></option>
                      <option value="トマト">トマト</option>
                      <option value="きゅうり">きゅうり</option>
                      <option value="ピーマン">ピーマン</option>
                      <option value="なす">なす</option>
                      <option value="キャベツ">キャベツ</option>
                      <option value="ほうれん草">ほうれん草</option>
                      <option value="ねぎ">ねぎ</option>
                      <option value="レタス">レタス</option>
                      <option value="白菜">白菜</option>
                      <option value="さといも">さといも</option>
                      <option value="だいこん">だいこん</option>
                      <option value="にんじん">にんじん</option>
                      <option value="玉ねぎ">玉ねぎ</option>
                      <option value="豆類">豆類</option>
                      <option value="野菜（そのほか）">野菜（そのほか）</option>
                    </select>
            </div>
            <div class="input-group">
                <h4 class="question">野菜の産地は</h4>
                <div class="radio-inline-group">
                    <div class="four-parts">
                    <input type="radio" name="lunch_vegetable_produced" id="lunch_vegetable_produced1" value="地元"><label for="lunch_vegetable_produced1">地元</label>
                </div>
                    <div class="four-parts">
                    <input type="radio" name="lunch_vegetable_produced" id="lunch_vegetable_produced2" value="国産"><label for="lunch_vegetable_produced2">国産</label>
                </div>
                    <div class="four-parts">
                    <input type="radio" name="lunch_vegetable_produced" id="lunch_vegetable_produced3" value="輸入"><label for="lunch_vegetable_produced3">輸入</label>
                </div>
                    <div class="four-parts">
                    <input type="radio" name="lunch_vegetable_produced" id="lunch_vegetable_produced4" value="わかりません"><label for="lunch_vegetable_produced4">不明</label>
                </div>
                </div>
            </div>
            <div class="input-group">
                <h4 class="question">主菜の分量は</h4>
                <div class="radio-inline-group">
                    <div class="three-parts">
                    <input type="radio" name="lunch_main_volumn" id="lunch_main_volumn1" value="少ない"><label for="lunch_main_volumn1">少ない</label>
                </div>
                    <div class="three-parts">
                    <input type="radio" name="lunch_main_volumn" id="lunch_main_volumn2" value="普通"><label for="lunch_main_volumn2">普通</label>
                </div>
                    <div class="three-parts">
                    <input type="radio" name="lunch_main_volumn" id="lunch_main_volumn3" value="多い"><label for="lunch_main_volumn3">多い</label>
                </div>
                </div>
            </div>
            <div class="input-group">
                <h4 class="question">主菜は何がメインですか？</h4>
                    <select class="form-select" name="lunch_main_type">
                      <option selected></option>
                      <option value="さんま">さんま</option>
                      <option value="さば">さば</option>
                      <option value="さけ・ます">さけ・ます</option>
                      <option value="ぶり">ぶり</option>
                      <option value="まぐろ">まぐろ</option>
                      <option value="魚介類（そのほか）">魚介類（そのほか）</option>
                      <option value="乳製品">乳製品</option>
                      <option value="卵">卵</option>
                      <option value="鶏肉">鶏肉</option>
                      <option value="豚肉（国産）">豚肉（国産）</option>
                      <option value="豚肉（輸入）">豚肉（輸入）</option>
                      <option value="牛肉（国産）">牛肉（国産）</option>
                      <option value="牛肉（輸入）">牛肉（輸入）</option>
                      <option value="肉類（そのほか）">肉類（そのほか）</option>
                    </select>
            </div>
            <div class="input-group">
                <h4 class="question">主菜の産地は</h4>
                <div class="radio-inline-group">
                    <div class="four-parts">
                    <input type="radio" name="lunch_main_produced" id="lunch_main_produced1" value="地元"><label for="lunch_main_produced1">地元</label>
                </div>
                    <div class="four-parts">
                    <input type="radio" name="lunch_main_produced" id="lunch_main_produced2" value="国産"><label for="lunch_main_produced2">国産</label>
                </div>
                    <div class="four-parts">
                    <input type="radio" name="lunch_main_produced" id="lunch_main_produced3" value="輸入"><label for="lunch_main_produced3">輸入</label>
                </div>
                    <div class="four-parts">
                    <input type="radio" name="lunch_main_produced" id="lunch_main_produced4" value="わかりません"><label for="lunch_main_produced4">不明</label>
                </div>
            </div>
            </div>
        </section>
        <section class="dinner">
            <h3>晩ご飯について</h3>
            <div class="input-group">
                <label for="dinner_image" class="input-group-text question">
                    晩ごはんを撮影しましょう
                </label>
                    <div class="upload-img">
                <label for="dinner_image">
                    晩ごはんを撮影しましょう
                </label><input type="file" class="form-control" name="dinner_image" id="dinner_image">
                    <img id="dinner_img"><div class="fileclear js-upload-fileclear">選択ファイルをクリア</div></div>
            </div>
            <div class="input-group">
                <h4 class="question">晩ご飯は外食ですか？</h4>
                <div class="radio-inline-group">
                    <div class="two-parts">
                    <input type="radio" name="dinner_place" id="dinner_place1" value="自炊"><label for="dinner_place1">自炊</label>
                </div>
                    <div class="two-parts">
                    <input type="radio" name="dinner_place" id="dinner_place2" value="外食"><label for="dinner_place2">外食</label>
                </div>
                </div>
            </div>
            <div class="input-group">
                <h4 class="question">ご飯の種類は何ですか？</h4>
                <div class="radio-inline-group">
                    <div class="four-parts">
                        <input type="radio" name="dinner_type" id="dinner_type1" value="定食"><label for="dinner_type1">定食</label>
                    </div>
                    <div class="four-parts">
                        <input type="radio" name="dinner_type" id="dinner_type2" value="丼"><label for="dinner_type2">丼</label>
                    </div>
                    <div class="four-parts">
                        <input type="radio" name="dinner_type" id="dinner_type3" value="麺類"><label for="dinner_type3">麺類</label>
                    </div>
                    <div class="four-parts">
                        <input type="radio" name="dinner_type" id="dinner_type4" value="パン"><label for="dinner_type4">パン</label>
                    </div>
                </div>
            </div>
            <div class="input-group">
                <h4 class="question">量はいつもに比べて</h4>
                <div class="radio-inline-group">
                    <div class="three-parts">
                    <input type="radio" name="dinner_volumn" id="dinner_volumn1" value="小盛り"><label for="dinner_volumn1">小盛り</label>
                </div><div class="three-parts">
                    <input type="radio" name="dinner_volumn" id="dinner_volumn2" value="普通盛り"><label for="dinner_volumn2">普通盛り</label>
                </div>
                    <div class="three-parts">
                    <input type="radio" name="dinner_volumn" id="dinner_volumn3" value="大盛り"><label for="dinner_volumn3">大盛り</label>
                </div>
                    
                </div>
            </div>
            <div class="input-group">
                <h4 class="question">野菜の分量は</h4>
                <div class="radio-inline-group">
                    <div class="three-parts">
                    <input type="radio" name="dinner_vegetable_volumn" id="dinner_vegetable_volumn1" value="少ない"><label for="dinner_vegetable_volumn1">少ない</label>
                </div>
                    <div class="three-parts">
                    <input type="radio" name="dinner_vegetable_volumn" id="dinner_vegetable_volumn2" value="普通"><label for="dinner_vegetable_volumn2">普通</label>
                </div><div class="three-parts">
                    <input type="radio" name="dinner_vegetable_volumn" id="dinner_vegetable_volumn3" value="多い"><label for="dinner_vegetable_volumn3">多い</label>
                </div>
                    
                </div>
            </div>
            <div class="input-group">
                <h4 class="question">野菜は何がメインですか？</h4>
                    <select class="form-select" name="dinner_vegetable_type">
                      <option selected></option>
                      <option value="トマト">トマト</option>
                      <option value="きゅうり">きゅうり</option>
                      <option value="ピーマン">ピーマン</option>
                      <option value="なす">なす</option>
                      <option value="キャベツ">キャベツ</option>
                      <option value="ほうれん草">ほうれん草</option>
                      <option value="ねぎ">ねぎ</option>
                      <option value="レタス">レタス</option>
                      <option value="白菜">白菜</option>
                      <option value="さといも">さといも</option>
                      <option value="だいこん">だいこん</option>
                      <option value="にんじん">にんじん</option>
                      <option value="玉ねぎ">玉ねぎ</option>
                      <option value="豆類">豆類</option>
                      <option value="野菜（そのほか）">野菜（そのほか）</option>
                    </select>
            </div>
            <div class="input-group">
                <h4 class="question">野菜の産地は</h4>
                <div class="radio-inline-group">
                    <div class="four-parts">
                    <input type="radio" name="dinner_vegetable_produced" id="dinner_vegetable_produced1" value="地元"><label for="dinner_vegetable_produced1">地元</label>
                </div>
                    <div class="four-parts">
                    <input type="radio" name="dinner_vegetable_produced" id="dinner_vegetable_produced2" value="国産"><label for="dinner_vegetable_produced2">国産</label>
                </div>
                    <div class="four-parts">
                    <input type="radio" name="dinner_vegetable_produced" id="dinner_vegetable_produced3" value="輸入"><label for="dinner_vegetable_produced3">輸入</label>
                </div>
                    <div class="four-parts">
                    <input type="radio" name="dinner_vegetable_produced" id="dinner_vegetable_produced4" value="わかりません"><label for="dinner_vegetable_produced4">不明</label>
                </div>
                </div>
            </div>
            <div class="input-group">
                <h4 class="question">主菜の分量は</h4>
                <div class="radio-inline-group">
                    <div class="three-parts">
                    <input type="radio" name="dinner_main_volumn" id="dinner_main_volumn1" value="少ない"><label for="dinner_main_volumn1">少ない</label>
                </div>
                    <div class="three-parts">
                    <input type="radio" name="dinner_main_volumn" id="dinner_main_volumn2" value="普通"><label for="dinner_main_volumn2">普通</label>
                </div><div class="three-parts">
                    <input type="radio" name="dinner_main_volumn" id="dinner_main_volumn3" value="多い"><label for="dinner_main_volumn3">多い</label>
                </div>
                    
                </div>
            </div>
            <div class="input-group">
                <h4 class="question">主菜は何がメインですか？</h4>
                    <select class="form-select" name="dinner_main_type">
                      <option selected></option>
                      <option value="さんま">さんま</option>
                      <option value="さば">さば</option>
                      <option value="さけ・ます">さけ・ます</option>
                      <option value="ぶり">ぶり</option>
                      <option value="まぐろ">まぐろ</option>
                      <option value="魚介類（そのほか）">魚介類（そのほか）</option>
                      <option value="乳製品">乳製品</option>
                      <option value="卵">卵</option>
                      <option value="鶏肉">鶏肉</option>
                      <option value="豚肉（国産）">豚肉（国産）</option>
                      <option value="豚肉（輸入）">豚肉（輸入）</option>
                      <option value="牛肉（国産）">牛肉（国産）</option>
                      <option value="牛肉（輸入）">牛肉（輸入）</option>
                      <option value="肉類（そのほか）">肉類（そのほか）</option>
                    </select>
            </div>
            <div class="input-group">
                <h4 class="question">主菜の産地は</h4>
                <div class="radio-inline-group">
                    <div class="four-parts">
                    <input type="radio" name="dinner_main_produced" id="dinner_main_produced1" value="地元"><label for="dinner_main_produced1">地元</label>
                </div>
                    <div class="four-parts">
                    <input type="radio" name="dinner_main_produced" id="dinner_main_produced2" value="国産"><label for="dinner_main_produced2">国産</label>
                </div>
                    <div class="four-parts">
                    <input type="radio" name="dinner_main_produced" id="dinner_main_produced3" value="輸入"><label for="dinner_main_produced3">輸入</label>
                </div>
                    <div class="four-parts">
                    <input type="radio" name="dinner_main_produced" id="dinner_main_produced4" value="わかりません"><label for="dinner_main_produced4">不明</label>
                </div>
            </div>
            </div>
  
        </section>
        <section class="life">
            <h3>ライフについて</h3>
            <div class="input-group">
                <span class="input-group-text question">今日は運動していますか？</span>
                <input type="number" pattern="\d*" min="0" class="form-control" name="sports_time">
                <span class="input-group-text">時間</span>
            </div>
            <div class="input-group">
                <h4 class="question">運動の場所はどこですか？</h4>
                <div class="radio-inline-group">
                    <div class="two-parts">
                    <input  type="radio" name="sports_place" id="sports_place1" value="屋外"><label for="sports_place1">屋外</label>
                </div>
                    <div class="two-parts">
                    <input  type="radio" name="sports_place" id="sports_place2" value="ジム"><label for="sports_place2">ジム</label>
                </div>
                </div>
            </div>
            <div class="input-group">
                <h4 class="question">なんの運動をしていますか？</h4>
                    <select class="form-select" name="sports_type">
                      <option selected></option>
                      <option value="散歩">散歩</option>
                      <option value="ジョギング">ジョギング</option>
                      <option value="筋トレ">筋トレ</option>
                      <option value="泳ぐ">泳ぐ</option>
                      <option value="ヨガ">ヨガ</option>
                      <option value="瞑想">瞑想</option>
                    </select>
            </div>
            <div class="input-group">
                <h4 class="question">休みの時間はどう過ごしましたか？</h4>
                    <select class="form-select" name="rest_type">
                      <option selected></option>
                      <option value="街歩き">街歩き</option>
                      <option value="近所の人とおしゃべり">近所の人とおしゃべり</option>
                      <option value="テレビ">テレビ</option>
                      <option value="ゲーム">ゲーム</option>
                    </select>
                    <div class="input-group">
                        <input type="number" pattern="\d*" min="0" class="form-control" name="rest_time">
                        <span class="input-group-text">時間</span>
                    </div>
            </div>
            <!-- <div class="input-group">
                <h4 class="question">今日は買い物しましたか？</h4>
                <div class="input-group price">
                    <span class="input-group-text">家電製品</span>
                    <input type="number" pattern="\d*" min="0" class="form-control price" name="shopping_ce">
                    <span class="input-group-text">円</span>
                </div>
                <div class="input-group price">
                    <span class="input-group-text">衣類</span>
                    <input type="number" pattern="\d*" min="0" class="form-control price" name="shopping_cloth">
                    <span class="input-group-text">円</span>
                </div>
                <div class="input-group price">
                    <span class="input-group-text">スポーツ・趣味用品</span>
                    <input type="number" pattern="\d*" min="0" class="form-control" name="shopping_hobby">
                    <span class="input-group-text">円</span>
                </div>
                <div class="input-group price">
                    <span class="input-group-text">紙・文房具</span>
                    <input type="number" pattern="\d*" min="0" class="form-control" name="shopping_office">
                    <span class="input-group-text">円</span>
                </div>
                <div class="input-group price">
                    <span class="input-group-text">日用品・医薬品</span>
                    <input type="number" pattern="\d*" min="0" class="form-control" name="shopping_daily">
                    <span class="input-group-text">円</span>
                </div>
                <div class="input-group price">
                    <span class="input-group-text">タバコ</span>
                    <input type="number" pattern="\d*" min="0" class="form-control" name="shopping_tabacco">
                    <span class="input-group-text">円</span>
                </div>
                <div class="input-group price">
                    <span class="input-group-text">そのた</span>
                    <input type="number" pattern="\d*" min="0" class="form-control" name="shopping_other">
                    <span class="input-group-text">円</span>
                </div>
            </div> -->
            
  
        </section>

<section class="submitArea">
  <div class="btnsubmit">
            <button type="submit">更新</button>      
        </div>
</section>
        </form>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>        
  <script>

$('#move-button1').click(function() {
    let dep = $('#move_out_departure1').val();
    let arr = $('#move_out_arrival1').val();
    let url_str = "/today/route?departure="+dep+"&arrival="+arr;
    $.ajax({
    type: "get",
    url: url_str, 
    contentType: 'application/json',
    dataType: "json",
    async: false, 
  }).then(
    function (distance) {
      $('#move_out_distance1').val(distance);
    },
    function () {
      // jsonの読み込みに失敗
      $('#move_out_distance1').val(0);
    }
  );
});

$('#move-button2').click(function() {

    let dep = $('#move_out_departure2').val();
    let arr = $('#move_out_arrival2').val();
    let url_str = "/today/route?departure="+dep+"&arrival="+arr;
    $.ajax({
    type: "get",
    url: url_str,
    contentType: 'application/json',
    dataType: "json",
    async: false,
  }).then(
    function (distance) {
      $('#move_out_distance2').val(distance);
    },
    function () {
      // jsonの読み込みに失敗
      $('#move_out_distance2').val(0);
    }
  );
});

$('#move-button3').click(function() {
    let dep = $('#move_out_departure3').val();
    let arr = $('#move_out_arrival3').val();
    let url_str = "/today/route?departure="+dep+"&arrival="+arr;
    $.ajax({
    type: "get",
    url: url_str,
    contentType: 'application/json',
    dataType: "json",
    async: false,
  }).then(
    function (distance) {
      $('#move_out_distance3').val(distance);
    },
    function () {
      // jsonの読み込みに失敗
      $('#move_out_distance3').val(0);
    }
  );
});

$('#move-button4').click(function() {
    let dep = $('#move_out_departure4').val();
    let arr = $('#move_out_arrival4').val();
    let url_str = "/today/route?departure="+dep+"&arrival="+arr;
    $.ajax({
    type: "get",
    url: url_str,
    contentType: 'application/json',
    dataType: "json",
    async: false,
  }).then(
    function (distance) {
      $('#move_out_distance4').val(distance);
    },
    function () {
      // jsonの読み込みに失敗
      $('#move_out_distance4').val(0);
    }
  );
});
    
$("#breakfast_image").on("change", function (e) {
var reader = new FileReader();
reader.onload = function (e) {
    $("#breakfast_img").attr("src", e.target.result);
}
reader.readAsDataURL(e.target.files[0]);
});

$("#lunch_image").on("change", function (e) {
var reader = new FileReader();
reader.onload = function (e) {
    $("#lunch_img").attr("src", e.target.result);
}
reader.readAsDataURL(e.target.files[0]);
});
$("#dinner_image").on("change", function (e) {
var reader = new FileReader();
reader.onload = function (e) {
    $("#dinner_img").attr("src", e.target.result);
}
reader.readAsDataURL(e.target.files[0]);
});


$(function() {
  $('.breakfast #breakfast_image').on('change', function () {
    let file = $(this).prop('files')[0];
    $('.breakfast .js-upload-fileclear').show();
  });
  $('.breakfast .js-upload-fileclear').click(function() {
    $('.breakfast #breakfast_img').attr("src", "");
    $(this).hide();
  });
  $('.lunch #lunch_image').on('change', function () {
    let file = $(this).prop('files')[0];
    $('.lunch .js-upload-fileclear').show();
  });
  $('.lunch .js-upload-fileclear').click(function() {
    $('.lunch #lunch_img').attr("src", "");
    $(this).hide();
  });
  $('.dinner #dinner_image').on('change', function () {
    let file = $(this).prop('files')[0];
    $('.dinner .js-upload-fileclear').show();
  });
  $('.dinner .js-upload-fileclear').click(function() {
    $('.dinner #dinner_img').attr("src", "");
    $(this).hide();
  });
});
  </script>
    
    
    </x-layout>