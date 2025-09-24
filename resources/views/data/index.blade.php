<x-layout>
<x-slot name="body_id">
  <body id="data">
</x-slot>
    <div class="MainContents">
    <h2>データ一覧</h2>
        <section class="currently">
            <h4>過去のエネルギー消費量</h4>
            <table class="table table-bordered table-sm">
            <tr>
                <td>電気使用量</td>
                @foreach ($power_kw as $val)
                <td>{{$val}}Kw</td>
                @endforeach
            </tr>
            <tr>
                <td>電気支払金額</td>
                @foreach ($power_amount as $val)
                <td>{{$val}}円</td>
                @endforeach
            </tr>
            <tr>
                <td>ガス使用量</td>
                @foreach ($gas_m as $val)
                <td>{{$val}}M3</td>
                @endforeach
            </tr>
            <tr>
                <td>ガス料金</td>
                @foreach ($gas_amount as $val)
                <td>{{$val}}円</td>
                @endforeach
            </tr>
            <tr>
                <td>灯油使用量</td>
                @foreach ($kerosine_l as $val)
                <td>{{$val}}L</td>
                @endforeach
            </tr>
            <tr>
                <td>灯油料金</td>
                @foreach ($kerosine_amount as $val)
                <td>{{$val}}円</td>
                @endforeach
            </tr>
            </table>
        </section>
        <section class="currently">
            <h4>Daily activity</h4>
            <table class="table table-bordered table-sm">
            <tr>
                <td>働く･オフィス</td>
                @foreach ($work_office as $val)
                <td>{{$val}}時間</td>
                @endforeach
            </tr>
            <tr>
                <td>働く･在宅勤務</td>
                @foreach ($work_soho as $val)
                <td>{{$val}}時間</td>
                @endforeach
            </tr>
            <tr>
                <td>働く･サードプレイス</td>
                @foreach ($work_3pl as $val)
                <td>{{$val}}時間</td>
                @endforeach
            </tr>
            <tr>
                <td>生活</td>
                @foreach ($life as $val)
                <td>{{$val}}時間</td>
                @endforeach
            </tr>
            <tr>
                <td>移動する</td>
                @foreach ($move as $val)
                <td>{{$val}}時間</td>
                @endforeach
            </tr>
            </table>
        </section>
        <section class="currently">
            <h4>オフィスでの活動について</h4>
            <table class="table table-bordered table-sm">
            <tr>
                <td>電気をつけた時間</td>
                @foreach ($light_time as $val)
                <td>{{$val}}時間</td>
                @endforeach
            </tr>
            <tr>
                <td>空調をつけた時間</td>
                @foreach ($ac_time as $val)
                <td>{{$val}}時間</td>
                @endforeach
            </tr>
            <tr>
                <td>何枚印刷した</td>
                @foreach ($printed_paper as $val)
                <td>{{$val}}枚</td>
                @endforeach
            </tr>
            <tr>
                <td>何時間パソコンをつけた</td>
                @foreach ($pc_time as $val)
                <td>{{$val}}時間</td>
                @endforeach
            </tr>
            <tr>
                <td>マイカップ日</td>
                @foreach ($drink_cup_type as $val)
                <td>{{$val}}</td>
                @endforeach
            </tr>
            </table>
        </section>
        <section class="currently">
            <h4>移動するについて</h4>
            <table class="table table-bordered table-sm">
            <tr>
                <td>階段を利用した回数</td>
                @foreach ($move_floor_number as $val)
                <td>{{$val}}回</td>
                @endforeach
            </tr>
            <tr>
                <td>外出回数</td>
                @foreach ($move_out_number as $val)
                <td>{{$val}}回</td>
                @endforeach
            </tr>
            </table>
        </section>

        <section class="currently">
            <h4>ご飯</h4>
            <table class="table table-bordered table-sm">
            <tr>
                <td>朝ご飯</td>
                @foreach ($breakfast_image as $val)
                <td>
                    <img src="{{$val ? asset('storage/' . $val) : asset('/images/no_photo.png')}}" alt=""  width="80" />
                </td>
                @endforeach
            </tr>
            <tr>
                <td>昼ご飯</td>
                @foreach ($lunch_image as $val)
                <td>
                    <img src="{{$val ? asset('storage/' . $val) : asset('/images/no_photo.png')}}" alt=""  width="80" />
                </td>
                @endforeach
            </tr>
            <tr>
                <td>晩ご飯</td>
                @foreach ($dinner_image as $val)
                <td>
                    <img src="{{$val ? asset('storage/' . $val) : asset('/images/no_photo.png')}}" alt=""  width="80" />
                </td>
                @endforeach
            </tr>
            </table>
        </section>
    </div>

</x-layout>