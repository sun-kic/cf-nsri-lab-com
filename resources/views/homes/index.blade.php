<x-layout>
<x-slot name="body_id">
  <body id="homes">
</x-slot>
    <script type="text/javascript" src="https://fastly.jsdelivr.net/npm/echarts@5.3.3/dist/echarts.min.js"></script>
    <div class="MainContents">
        <h2 style="margin-bottom: 0;">{{$user->name}}さんの今日のCO<sub>2</sub>排出量サマリー</h2>
    @php
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

    <section class="region-info">
      <h3>あなたの地域のおすすめ情報</h3>

      <div class="renewable-block">
        <h4 class="renewable-block__title">再エネを導入している施設</h4>
        <div class="renewable-tabs" role="tablist" aria-label="再エネ施設のカテゴリ">
          <button type="button" class="renewable-tab is-active" role="tab" aria-selected="true" aria-controls="renewable-panel" id="tab-cafe" data-category="cafe">カフェ</button>
          <button type="button" class="renewable-tab" role="tab" aria-selected="false" aria-controls="renewable-panel" id="tab-ski" data-category="ski">スキーリゾート</button>
          <button type="button" class="renewable-tab" role="tab" aria-selected="false" aria-controls="renewable-panel" id="tab-onsen" data-category="onsen">温泉施設</button>
          <button type="button" class="renewable-tab" role="tab" aria-selected="false" aria-controls="renewable-panel" id="tab-hotel" data-category="hotel">ホテル</button>
        </div>
        <div class="renewable-table-wrap" id="renewable-panel" role="tabpanel" aria-labelledby="tab-cafe">
          <table class="renewable-table">
            <thead>
              <tr>
                <th scope="col">施設名</th>
                <th scope="col">施設紹介</th>
                <th scope="col">アドレス</th>
              </tr>
            </thead>
            <tbody id="renewable-facility-tbody"></tbody>
          </table>
        </div>
      </div>

      <div id="map" tabindex="-1" style="width: 100%; height: 400px; border-radius: 10px; margin-top: 20px;"></div>
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
// Google Mapの初期化（施設名リンクから Geocoding で住所検索して表示）
function initMap() {
  const hakuba = { lat: 36.6981, lng: 137.8617 };
  const mapEl = document.getElementById('map');
  const map = new google.maps.Map(mapEl, {
    zoom: 13,
    center: hakuba,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  const geocoder = new google.maps.Geocoder();
  const marker = new google.maps.Marker({
    position: hakuba,
    map: map,
    title: '白馬村'
  });
  const infoWindow = new google.maps.InfoWindow({
    content: '<h4 style="margin:0 0 6px;font-size:1rem;">白馬村</h4><p style="margin:0;font-size:0.9rem;">長野県北安曇郡白馬村</p>'
  });
  marker.addListener('click', function () {
    infoWindow.open(map, marker);
  });

  window.showFacilityFromAddress = function (name, address) {
    if (!geocoder || !map || !marker) {
      return;
    }
    const query = (address || '').trim();
    if (!query) {
      alert('アドレスが登録されていません。');
      return;
    }
    geocoder.geocode({ address: query, region: 'jp' }, function (results, status) {
      if (status === 'OK' && results[0]) {
        const loc = results[0].geometry.location;
        map.setCenter(loc);
        map.setZoom(16);
        marker.setPosition(loc);
        marker.setTitle(name);
        const esc = function (t) {
          const d = document.createElement('div');
          d.textContent = t;
          return d.innerHTML;
        };
        infoWindow.setContent(
          '<h4 style="margin:0 0 6px;font-size:1rem;">' + esc(name) + '</h4><p style="margin:0;font-size:0.9rem;">' + esc(address) + '</p>'
        );
        infoWindow.open(map, marker);
        mapEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      } else {
        alert('住所から位置を特定できませんでした。アドレスの表記を確認するか、Google Cloud で Geocoding API が有効か・APIキーの制限を確認してください。\nステータス: ' + status);
      }
    });
  };
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

// 再エネ施設タブ（地図の上のブロック）— データはDBから渡す
(function () {
  const renewableFacilities = @json($renewable_facilities_by_category);

  function escapeHtml(s) {
    const div = document.createElement('div');
    div.textContent = s;
    return div.innerHTML;
  }

  function escapeAttr(s) {
    return String(s)
      .replace(/&/g, '&amp;')
      .replace(/"/g, '&quot;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;');
  }

  function renderCategory(category) {
    const tbody = document.getElementById('renewable-facility-tbody');
    if (!tbody) return;
    const rows = renewableFacilities[category] || [];
    tbody.innerHTML = rows
      .map(function (r) {
        return (
          '<tr><td><a href="#map" class="renewable-facility-link" data-name="' +
          escapeAttr(r.name) +
          '" data-address="' +
          escapeAttr(r.address) +
          '">' +
          escapeHtml(r.name) +
          '</a></td><td>' +
          escapeHtml(r.intro) +
          '</td><td>' +
          escapeHtml(r.address) +
          '</td></tr>'
        );
      })
      .join('');
  }

  document.addEventListener('DOMContentLoaded', function () {
    const tbody = document.getElementById('renewable-facility-tbody');
    if (tbody) {
      tbody.addEventListener('click', function (e) {
        const link = e.target.closest('a.renewable-facility-link');
        if (!link) return;
        e.preventDefault();
        const name = link.getAttribute('data-name') || '';
        const address = link.getAttribute('data-address') || '';
        if (typeof window.showFacilityFromAddress === 'function') {
          window.showFacilityFromAddress(name, address);
        } else {
          alert('地図の読み込みが完了するまで少し待ってから、もう一度クリックしてください。');
        }
      });
    }

    const tabs = document.querySelectorAll('.renewable-tab');
    const panel = document.getElementById('renewable-panel');
    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        const cat = tab.getAttribute('data-category');
        tabs.forEach(function (t) {
          t.classList.remove('is-active');
          t.setAttribute('aria-selected', 'false');
        });
        tab.classList.add('is-active');
        tab.setAttribute('aria-selected', 'true');
        if (panel) panel.setAttribute('aria-labelledby', tab.id);
        renderCategory(cat);
      });
    });
    renderCategory('cafe');
  });
})();
</script>

<style>
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

.renewable-block {
  background: #fff;
  border-radius: 15px;
  padding: 20px 18px 22px;
  margin-bottom: 4px;
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
}

.renewable-block__title {
  margin: 0 0 16px;
  font-size: 1.1em;
  font-weight: bold;
  color: #333;
  text-align: center;
}

.renewable-tabs {
  display: flex;
  flex-wrap: wrap;
  gap: 4px;
  padding: 6px;
  background: #e8eaed;
  border-radius: 12px;
  margin-bottom: 16px;
  justify-content: center;
}

.renewable-tab {
  flex: 1 1 auto;
  min-width: 0;
  padding: 10px 12px;
  border: 1px solid transparent;
  border-radius: 10px;
  background: transparent;
  color: #444;
  font-size: 0.88em;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.15s, border-color 0.15s, box-shadow 0.15s;
}

.renewable-tab:hover {
  background: rgba(255, 255, 255, 0.55);
}

.renewable-tab.is-active {
  background: #fff;
  border-color: #d0d4db;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
  color: #222;
}

.renewable-table-wrap {
  overflow-x: auto;
  border-radius: 12px;
  border: 1px solid #e0e4e8;
  -webkit-overflow-scrolling: touch;
}

.renewable-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.92em;
  background: #fff;
}

.renewable-table th,
.renewable-table td {
  padding: 12px 14px;
  text-align: left;
  border-bottom: 1px solid #e8eaed;
  vertical-align: top;
}

.renewable-table th {
  background: #f4f6f8;
  color: #333;
  font-weight: bold;
  white-space: nowrap;
}

.renewable-table tbody tr:last-child td {
  border-bottom: none;
}

.renewable-table td:nth-child(2) {
  color: #555;
}

a.renewable-facility-link {
  color: #2d6a4f;
  font-weight: 600;
  text-decoration: underline;
  text-underline-offset: 2px;
}

a.renewable-facility-link:hover {
  color: #1b4332;
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

  .renewable-block {
    padding: 16px 12px 18px;
  }

  .renewable-tabs {
    flex-direction: column;
  }

  .renewable-tab {
    width: 100%;
  }

  .renewable-table th,
  .renewable-table td {
    padding: 10px 10px;
    font-size: 0.88em;
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

  .renewable-block__title {
    font-size: 1em;
  }
  
  #map {
    height: 250px;
  }
}


</style>

             
        </div>


</x-layout>