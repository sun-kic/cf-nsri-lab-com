<x-layout>
<x-slot name="body_id">
  <body id="homes">
</x-slot>
    <script type="text/javascript" src="https://fastly.jsdelivr.net/npm/echarts@5.3.3/dist/echarts.min.js"></script>
    <div class="MainContents">
        <h2>{{$user->name}}さんのCO<sub>2</sub>排出量サマリー</h2>
    @php
    if ($carbon){
      $works_carbon = $carbon->accumulated_works_carbon;
    }else{
      $works_carbon = 0;
    }
    if ($carbon){
      $move_carbon = $carbon->accumulated_move_carbon;
    }else{
      $move_carbon = 0;
    }
    if ($carbon){
      $life_carbon = $carbon->accumulated_life_carbon;
    }else{
      $life_carbon = 0;
    }
    if ($carbon){
      $food_carbon = $carbon->accumulated_foods_carbon;
    }else{
      $food_carbon = 0;
    }
    if ($carbon_today){
      $today_works_carbon = $carbon_today->works_carbon;
      $today_move_carbon = $carbon_today->move_carbon;
      $today_life_carbon = $carbon_today->life_carbon;
      $today_foods_carbon = $carbon_today->foods_carbon;
      $todays_carbon_sum = $carbon_today->works_carbon + $carbon_today->move_carbon + $carbon_today->life_carbon + $carbon_today->foods_carbon;
    }else{
      $today_works_carbon = 0;
      $today_move_carbon = 0;
      $today_life_carbon = 0;
      $today_foods_carbon = 0;
      $todays_carbon_sum = 0;
    }
    

      $carbon_array = [
        "work" => $works_carbon,
        "move" => $move_carbon,
        "life" => $life_carbon,
        "food" => $food_carbon
    ];
      $maxes = array_keys($carbon_array,max($carbon_array));
      // dd($carbon_array);
    @endphp

<section id="mainData">
    <section class="emissions icon_main">
        @if (is_null($carbon))
        <h3><div>0<span>トン</span></div><div class="average">（平均<div>0<span>トン</span></div>）</div>合計</h3>
        @else
            <h3>本日合計<div>{{$todays_carbon_sum}}<span>キロ</span></div><div class="average">（平均<div> {{number_format($carbon->accumulated_total_carbon/$days_count,2)}}  <span>キロ</span></div>）</div></h3>
        @endif
    </section>
    <section class="myData">
      <ul>
        @if (is_null($carbon))
            <li><div class="icon_work">ワーク</div><div class="data">0<span>キロ</span></div></li>
            <li><div class="icon_move">移動</div><div class="data">0<span>キロ</span></div></li>
        @else
            <li><div class="icon_work">ワーク</div><div class="data">本日{{$today_works_carbon}}<span>キロ</span></div><div class="data">平均{{number_format($carbon->accumulated_works_carbon/$days_count,2)}}<span>キロ</span></div></li>
            <li><div class="icon_move">移動</div><div class="data">本日{{$today_move_carbon}}<span>キロ</span></div><div class="data">平均{{number_format($carbon->accumulated_move_carbon/$days_count,2)}}<span>キロ</span></div></li>
        @endif
        @if (is_null($carbon))
            <li><div class="icon_life">ライフ</div><div class="data">0<span>キロ</span></div></li>
            <li><div class="icon_meal">食事</div><div class="data">0<span>キロ</span></div></li>
        @else
            <li><div class="icon_life">ライフ</div><div class="data">本日{{$today_life_carbon}}<span>キロ</span></div><div class="data">平均{{number_format($carbon->accumulated_life_carbon/$days_count,2)}}<span>キロ</span></div></li>
            <li><div class="icon_meal">食事</div><div class="data">本日{{$today_foods_carbon}}<span>キロ</span></div><div class="data">平均{{number_format($carbon->accumulated_foods_carbon/$days_count,2)}}<span>キロ</span></div></li>
        @endif
      </ul>
    </section>
    </section>
    <section class="overview">
      @if ($maxes[0] == "work")
        <h3>あなたは、仕事系人間です。</h3>
      @endif
      @if ($maxes[0] == "move")
        <h3>あなたは、動き回る系人間です。</h3>
      @endif
      @if ($maxes[0] == "life")
        <h3>あなたは、生活第一系人間です。</h3>
      @endif
      @if ($maxes[0] == "food")
        <h3>あなたは、大食い系人間です。</h3>
      @endif
        <dl>
          {{-- <dt>あなたについて</dt>
          <dd>「　　　　　」</dd>
          <dt>改善案</dt>
          <dd>「　　　　　」</dd> --}}
      </dl>
      <!--<div class="btnMore">
        <a href="" rel="noopener noreferrer">内容を詳しく知る</a></div>-->
    </section>

<section class="graphArea">
      <div id="graph"></div>
</section>

<script type="text/javascript">
                var dom = document.getElementById('graph');
                var myChart = echarts.init(dom, null, {
                  renderer: 'canvas',
                  useDirtyRect: false
                });
                var app = {};
                
                var option;
                let days = @json($days);
                let works = @json($works);
                let foods = @json($foods);
                let life = @json($life);
                let move = @json($move);
            
                option = {
                  color: ['#6786B2', '#8cc9a3', '#f2e4a0', '#f29fc5'],
              tooltip: {
                trigger: 'axis',
                axisPointer: {
                  type: 'shadow'
                }
              },
              legend: {},
              grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
              },
              xAxis: [
                {
                  type: 'category',
                  data: days
                }
              ],
              yAxis: [
                {
                  type: 'value'
                }
              ],
              series: [
                {
                  name: 'ワーク',
                  type: 'bar',
                  stack: 'carbon',
                  barWidth: 30,
                  emphasis: {
                    focus: 'series'
                  },
                  data: works
                },
                {
                  name: '移動',
                  type: 'bar',
                  stack: 'carbon',
                  barWidth: 30,
                  emphasis: {
                    focus: 'series'
                  },
                  data: move
                },
                {
                  name: 'ライフ',
                  type: 'bar',
                  stack: 'carbon',
                  barWidth: 30,
                  emphasis: {
                    focus: 'series'
                  },
                  data: life
                },
                {
                  name: '食事',
                  type: 'bar',
                  stack: 'carbon',
                  barWidth: 30,
                  emphasis: {
                    focus: 'series'
                  },
                  data: foods
                },
                
              ]
            };
            
                if (option && typeof option === 'object') {
                  myChart.setOption(option);
                }
            
                window.addEventListener('resize', myChart.resize);
              </script>

             
        </div>


</x-layout>