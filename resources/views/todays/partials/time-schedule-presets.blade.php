{{-- 2/6 時間入力: プリセット（index / create / edit 共通） --}}
<div class="time-schedule-presets">
  <p class="time-schedule-presets__title">スケジュールのよく使うパターン</p>
  <div class="time-schedule-presets__buttons" role="group" aria-label="時間帯プリセット">
    <button type="button" class="btn btn-sm time-schedule-presets__btn time-schedule-presets__btn--home" onclick="applyTodayTimePreset('zaitaku')">在宅</button>
    <button type="button" class="btn btn-sm time-schedule-presets__btn time-schedule-presets__btn--mixed" onclick="applyTodayTimePreset('zaitaku_shusha')">在宅・出社</button>
    <button type="button" class="btn btn-sm time-schedule-presets__btn time-schedule-presets__btn--mixed2" onclick="applyTodayTimePreset('shusha_zaitaku')">出社・在宅</button>
  </div>
  <p class="time-schedule-presets__hint">ボタンを押すと該当する時間帯が一括で入ります。あとからマス目をクリックして変更できます。</p>
</div>
<script>
(function () {
  var PREFIXES = ['work_office', 'work_soho', 'work_3pl', 'life', 'move'];

  function clearAllTimeSlots() {
    PREFIXES.forEach(function (p) {
      for (var h = 0; h <= 23; h++) {
        var el = document.getElementById(p + h);
        if (el) {
          el.checked = false;
        }
      }
    });
  }

  function setHours(prefix, hours) {
    hours.forEach(function (h) {
      var el = document.getElementById(prefix + h);
      if (el) {
        el.checked = true;
      }
    });
  }

  // 各チェックボックスは「h 時台（h:00〜h+1:00）」を表す
  var H9_TO_18 = [9, 10, 11, 12, 13, 14, 15, 16, 17]; // 9:00〜18:00（18:00終了＝17時台まで）
  var H18_TO_9 = [18, 19, 20, 21, 22, 23, 0, 1, 2, 3, 4, 5, 6, 7, 8]; // 18:00〜翌9:00
  var H19_TO_9 = [19, 20, 21, 22, 23, 0, 1, 2, 3, 4, 5, 6, 7, 8]; // 19:00〜翌9:00

  window.applyTodayTimePreset = function (preset) {
    clearAllTimeSlots();
    if (preset === 'zaitaku') {
      setHours('work_soho', H9_TO_18);
      setHours('life', H18_TO_9);
    } else if (preset === 'zaitaku_shusha') {
      setHours('work_soho', [9, 10, 11]);
      setHours('move', [12, 18]);
      setHours('work_office', [13, 14, 15, 16, 17]);
      setHours('life', H19_TO_9);
    } else if (preset === 'shusha_zaitaku') {
      setHours('work_office', [9, 10, 11]);
      setHours('move', [8, 12]);
      setHours('work_soho', [13, 14, 15, 16, 17]);
      setHours('life', H19_TO_9);
    }
  };
})();
</script>
