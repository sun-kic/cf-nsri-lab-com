<x-layout>
<x-slot name="body_id">
  <body id="homes">
</x-slot>
    <script type="text/javascript" src="https://fastly.jsdelivr.net/npm/echarts@5.3.3/dist/echarts.min.js"></script>
    <div class="MainContents">
        <h2 style="margin-bottom: 0;">{{$user->name}}さんの今日のCO<sub>2</sub>排出量サマリー</h2>
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
    <div id="pieChart" style="width: 100%; height: 200px; margin-bottom: 0; padding: 0;"></div>
    <section class="myData">
      <div style="display: flex; flex-wrap: nowrap; justify-content: space-between; gap: 10px; padding: 20px 0; overflow-x: auto;">
        @if (is_null($carbon))
            <div style="flex: 1; min-width: 0; text-align: center; background: #f8f9fa; border-radius: 12px; padding: 20px 10px; ">
              <div style="font-weight: bold; color: white; background-color: #6786B2; margin-bottom: 15px; font-size: 1.1em; padding: 5px 10px; border-radius: 5px;">働く</div>
                <div style="width: 50px; height: 50px; background: #6786B2; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;"><img src="/images/favicon.ico" alt="icon" style="width: 30px; height: 30px;"></div>
                <div style="font-size: 1.5em; color: #333; margin-bottom: 8px; font-weight: bold;">0<span style="font-size: 0.8em;">キロ</span></div>
                <div style="font-size: 0.9em; color: #666;">平均0<span style="font-size: 0.8em;">キロ</span></div>
            </div>
            <div style="flex: 1; min-width: 0; text-align: center; background: #f8f9fa; border-radius: 12px; padding: 20px 10px; ">
              <div style="font-weight: bold; color: white; background-color: #8cc9a3; margin-bottom: 15px; font-size: 1.0em; padding: 5px 10px; border-radius: 5px; white-space: nowrap;">移動する</div>
                <div style="width: 50px; height: 50px; background: #8cc9a3; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;"><img src="/images/favicon.ico" alt="icon" style="width: 30px; height: 30px;"></div>
                <div style="font-size: 1.5em; color: #333; margin-bottom: 8px; font-weight: bold;">0<span style="font-size: 0.8em;">キロ</span></div>
                <div style="font-size: 0.9em; color: #666;">平均0<span style="font-size: 0.8em;">キロ</span></div>
            </div>
        @else
            <div style="flex: 1; min-width: 0; text-align: center; background: #f8f9fa; border-radius: 12px; padding: 20px 10px; ">
                <div style="font-weight: bold; color: white; background-color: #6786B2; margin-bottom: 15px; font-size: 1.1em; padding: 5px 10px; border-radius: 5px;">働く</div>
                <div style="width: 50px; height: 50px; background: #6786B2; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;"><img src="/images/favicon.ico" alt="icon" style="width: 30px; height: 30px;"></div>
                <div style="font-size: 1.5em; color: #333; margin-bottom: 8px; font-weight: bold;">{{$today_works_carbon}}<span style="font-size: 0.8em;">キロ</span></div>
                <div style="font-size: 0.9em; color: #666;">平均{{number_format($carbon->accumulated_works_carbon/$days_count,2)}}<span style="font-size: 0.8em;">キロ</span></div>
            </div>
            <div style="flex: 1; min-width: 0; text-align: center; background: #f8f9fa; border-radius: 12px; padding: 20px 10px; ">
                <div style="font-weight: bold; color: white; background-color: #8cc9a3; margin-bottom: 15px; font-size: 1.0em; padding: 5px 10px; border-radius: 5px; white-space: nowrap;">移動する</div>
                <div style="width: 50px; height: 50px; background: #8cc9a3; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;"><img src="/images/favicon.ico" alt="icon" style="width: 30px; height: 30px;"></div>
                <div style="font-size: 1.5em; color: #333; margin-bottom: 8px; font-weight: bold;">{{$today_move_carbon}}<span style="font-size: 0.8em;">キロ</span></div>
                <div style="font-size: 0.9em; color: #666;">平均{{number_format($carbon->accumulated_move_carbon/$days_count,2)}}<span style="font-size: 0.8em;">キロ</span></div>
            </div>
        @endif
        @if (is_null($carbon))
            <div style="flex: 1; min-width: 0; text-align: center; background: #f8f9fa; border-radius: 12px; padding: 20px 10px; ">
                <div style="font-weight: bold; color: black; background-color: #f2e4a0; margin-bottom: 15px; font-size: 1.0em; padding: 5px 10px; border-radius: 5px; white-space: nowrap;">暮らす</div>
                <div style="width: 50px; height: 50px; background: #f2e4a0; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;"><img src="/images/favicon.ico" alt="icon" style="width: 30px; height: 30px;"></div>
                <div style="font-size: 1.5em; color: #333; margin-bottom: 8px; font-weight: bold;">0<span style="font-size: 0.8em;">キロ</span></div>
                <div style="font-size: 0.9em; color: #666;">平均0<span style="font-size: 0.8em;">キロ</span></div>
            </div>
            <div style="flex: 1; min-width: 0; text-align: center; background: #f8f9fa; border-radius: 12px; padding: 20px 10px; ">
                <div style="font-weight: bold; color: black; background-color: #f29fc5; margin-bottom: 15px; font-size: 1.0em; padding: 5px 10px; border-radius: 5px; white-space: nowrap;">食べる</div>
                <div style="width: 50px; height: 50px; background: #f29fc5; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;"><img src="/images/favicon.ico" alt="icon" style="width: 30px; height: 30px;"></div>
                <div style="font-size: 1.5em; color: #333; margin-bottom: 8px; font-weight: bold;">0<span style="font-size: 0.8em;">キロ</span></div>
                <div style="font-size: 0.9em; color: #666;">平均0<span style="font-size: 0.8em;">キロ</span></div>
            </div>
        @else
            <div style="flex: 1; min-width: 0; text-align: center; background: #f8f9fa; border-radius: 12px; padding: 20px 10px; ">
                <div style="font-weight: bold; color: black; background-color: #f2e4a0; margin-bottom: 15px; font-size: 1.0em; padding: 5px 10px; border-radius: 5px; white-space: nowrap;">暮らす</div>
                <div style="width: 50px; height: 50px; background: #f2e4a0; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;"><img src="/images/favicon.ico" alt="icon" style="width: 30px; height: 30px;"></div>
                <div style="font-size: 1.5em; color: #333; margin-bottom: 8px; font-weight: bold;">{{$today_life_carbon}}<span style="font-size: 0.8em;">キロ</span></div>
                <div style="font-size: 0.9em; color: #666;">平均{{number_format($carbon->accumulated_life_carbon/$days_count,2)}}<span style="font-size: 0.8em;">キロ</span></div>
            </div>
            <div style="flex: 1; min-width: 0; text-align: center; background: #f8f9fa; border-radius: 12px; padding: 20px 10px; ">
                <div style="font-weight: bold; color: black; background-color: #f29fc5; margin-bottom: 15px; font-size: 1.0em; padding: 5px 10px; border-radius: 5px; white-space: nowrap;">食べる</div>
                <div style="width: 50px; height: 50px; background: #f29fc5; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;"><img src="/images/favicon.ico" alt="icon" style="width: 30px; height: 30px;"></div>
                <div style="font-size: 1.5em; color: #333; margin-bottom: 8px; font-weight: bold;">{{$today_foods_carbon}}<span style="font-size: 0.8em;">キロ</span></div>
                <div style="font-size: 0.9em; color: #666;">平均{{number_format($carbon->accumulated_foods_carbon/$days_count,2)}}<span style="font-size: 0.8em;">キロ</span></div>
            </div>
        @endif
      </div>
    </section>
    </section>
    <section class="overview">
      <div class="owl-speech-container">
        <div class="owl-icon">
          <img src="/images/owl.png" alt="フクロウ" class="owl-image">
        </div>
        <div class="speech-bubble">
          @if ($maxes[0] == "work")
            <p>あなたは、<br>仕事系人間です！</p>
          @endif
          @if ($maxes[0] == "move")
            <p>あなたは、<br>動き回る系人間です！</p>
          @endif
          @if ($maxes[0] == "life")
            <p>あなたは、<br>生活第一系人間です！</p>
          @endif
          @if ($maxes[0] == "food")
            <p>あなたは、<br>大食い系人間です！</p>
          @endif
        </div>
      </div>
    </section>

    <section class="region-info">
      <h3>あなたの地域のおすすめ情報</h3>
      <div id="map" style="width: 100%; height: 400px; border-radius: 10px; margin-top: 15px;"></div>
    </section>


<script type="text/javascript">
                // 円グラフの実装
                var pieDom = document.getElementById('pieChart');
                var pieChart = echarts.init(pieDom, null, {
                  renderer: 'canvas',
                  useDirtyRect: false
                });
                
                var pieOption;
                let todayWorks = @json($today_works_carbon);
                let todayMove = @json($today_move_carbon);
                let todayLife = @json($today_life_carbon);
                let todayFoods = @json($today_foods_carbon);
                let todaysSum = @json($todays_carbon_sum);
                let averageTotal = @json($carbon ? number_format($carbon->accumulated_total_carbon/$days_count,2) : 0);
                
                // 円グラフのデータ
                var pieData = [
                    {value: todayWorks, name: '働く'},
                    {value: todayMove, name: '移動する'},
                    {value: todayLife, name: '暮らす'},
                    {value: todayFoods, name: '食べる'}
                ];
                
                pieOption = {
                    color: ['#6786B2', '#8cc9a3', '#f2e4a0', '#f29fc5'],
                    grid: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0,
                        containLabel: false
                    },
                    title: {
                        text: '今日の合計',
                        subtext: todaysSum + 'キロ\n平均 ' + averageTotal + 'キロ',
                        left: '50%',
                        top: '40%',
                        textAlign: 'center',
                        textVerticalAlign: 'middle',
                        textStyle: {
                            fontSize: 12,
                            fontWeight: 'bold'
                        },
                        subtextStyle: {
                            fontSize: 14,
                            color: '#666',
                            lineHeight: 14
                        }
                    },
                    tooltip: {
                        trigger: 'item',
                        formatter: '{a} <br/>{b}: {c}キロ ({d}%)'
                    },
                    legend: {
                        show: false
                    },
                    series: [
                        {
                            name: 'CO2排出量',
                            type: 'pie',
                            radius: ['50%', '70%'],
                            center: ['50%', '50%'],
                            avoidLabelOverlap: false,
                            itemStyle: {
                                borderRadius: 10,
                                borderColor: '#fff',
                                borderWidth: 2
                            },
                            label: {
                                show: false,
                                position: 'center'
                            },
                            emphasis: {
                                label: {
                                    show: true,
                                    fontSize: '20',
                                    fontWeight: 'bold'
                                }
                            },
                            labelLine: {
                                show: false
                            },
                            data: pieData
                        }
                    ]
                };
                
                if (pieOption && typeof pieOption === 'object') {
                    pieChart.setOption(pieOption);
                }
                
                window.addEventListener('resize', pieChart.resize);

              </script>

<script>
// Google Mapの初期化
function initMap() {
  // 白馬村の座標
  const hakuba = { lat: 36.6981, lng: 137.8617 };
  
  // マップの作成
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 13,
    center: hakuba,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  
  // マーカーの追加
  const marker = new google.maps.Marker({
    position: hakuba,
    map: map,
    title: "白馬村"
  });
  
  // 情報ウィンドウの追加
  const infoWindow = new google.maps.InfoWindow({
    content: "<h4>白馬村</h4><p>長野県北安曇郡白馬村</p>"
  });
  
  marker.addListener("click", () => {
    infoWindow.open(map, marker);
  });
}

// Google Maps APIの読み込み
function loadGoogleMaps() {
  const script = document.createElement('script');
  script.src = `https://maps.googleapis.com/maps/api/js?key={{ config('services.google.directions_key') }}&callback=initMap`;
  script.async = true;
  script.defer = true;
  document.head.appendChild(script);
}

// ページ読み込み後にGoogle Mapsを読み込み
document.addEventListener('DOMContentLoaded', loadGoogleMaps);
</script>

<style>
.owl-speech-container {
  display: flex !important;
  align-items: center;
  justify-content: center;
  gap: 15px;
  padding: 20px;
  background: #f8f9fa;
  border-radius: 15px;
  margin: 20px auto;
  flex-direction: row !important;
  flex-wrap: nowrap;
  max-width: 600px;
  width: 100%;
}

.owl-icon {
  flex-shrink: 0;
  order: 1;
}

.owl-image {
  width: 80px;
  height: 80px;
  object-fit: contain;
}

.speech-bubble {
  position: relative;
  background: #d0e2be;
  border-radius: 15px;
  padding: 15px 20px;
  flex: 1;
  max-width: 300px;
  order: 2;
}

.speech-bubble::before {
  content: '';
  position: absolute;
  left: -12px !important;
  top: 50% !important;
  transform: translateY(-50%) !important;
  width: 0;
  height: 0;
  border-top: 10px solid transparent !important;
  border-bottom: 10px solid transparent !important;
  border-right: 12px solid #d0e2be !important;
  border-left: none !important;
}

.speech-bubble p {
  margin: 0;
  color: #333;
  font-size: 1.1em;
  font-weight: bold;
  text-align: left;
  line-height: 1.4;
}

@media (max-width: 768px) {
  .owl-speech-container {
    flex-direction: column;
    text-align: center;
    gap: 10px;
    padding: 15px;
    justify-content: center;
    align-items: center;
    margin: 20px auto;
    max-width: 90%;
  }
  
  .owl-image {
    width: 60px;
    height: 60px;
  }
  
  .speech-bubble {
    max-width: 100%;
    margin-top: 10px;
  }
  
  .speech-bubble::before {
    left: -12px !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    border-top: 10px solid transparent !important;
    border-bottom: 10px solid transparent !important;
    border-right: 12px solid #d0e2be !important;
    border-left: none !important;
  }
  
  .speech-bubble p {
    font-size: 1em;
  }
}

@media (max-width: 480px) {
  .owl-speech-container {
    max-width: 95%;
    padding: 10px;
  }
  
  .owl-image {
    width: 50px;
    height: 50px;
  }
  
  .speech-bubble {
    padding: 12px 15px;
  }
  
  .speech-bubble p {
    font-size: 0.9em;
  }
}

.region-info {
  margin: 30px 0;
  padding: 20px;
  background: #f8f9fa;
  border-radius: 15px;
}

.region-info h3 {
  color: #333;
  font-size: 1.3em;
  font-weight: bold;
  margin-bottom: 15px;
  text-align: center;
}

#map {
  border: 1px solid #ddd;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
  .region-info {
    margin: 20px 0;
    padding: 15px;
  }
  
  .region-info h3 {
    font-size: 1.2em;
  }
  
  #map {
    height: 300px;
  }
}

@media (max-width: 480px) {
  .region-info {
    margin: 15px 0;
    padding: 10px;
  }
  
  .region-info h3 {
    font-size: 1.1em;
  }
  
  #map {
    height: 250px;
  }
}


</style>

             
        </div>


</x-layout>