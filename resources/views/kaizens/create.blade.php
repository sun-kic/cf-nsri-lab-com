<x-layout>
<x-slot name="body_id">
  <body id="kaizens">
</x-slot>
<div class="MainContents">
        <h2>本日、頑張ったこと！</h2>
        <section class="point">
        <h3>本日のポイント数は<strong>{{$point}}</strong>ポイントです</h3>
        <h3>今月のポイント数は<strong>{{$point_month}}</strong>ポイントです</h3>
        </section>
    <form method="POST" action="/kaizen/update">
        @csrf
            <section class="kaizens">
                <ul class="kaizenLists">
                    @php $i = 0; @endphp
            @foreach ($kaizen_items_random as $key=>$value)
                <li>
                    <input type="checkbox" class="btn-check" name="kaizen_items[]"id="label{{$i}}" value="{{$value}}" autocomplete="off">
                    <label for="label{{$i}}" id="action{{$key}}">{{$value}}</label><br>
                </li>
                @php $i++; @endphp
            @endforeach
        </ul>
</section>
            <section class="submitArea">
                <div class="btnsubmit">
                    <button type="submit">入力確定</button>
                </div>
            </section>
    </form>

        </div>
</x-layout>