<x-layout>
@section('title')
    <a href="{{ route('votes.index') }}">{{ $title }} </a>
@endsection
@section('title2', '結果')
    <div class="card mb-3">
        <h5 class="card-title p-3">
            {{ $voteSet->name }}
        </h5>
        <h6 class="card-subtitle px-3 text-muted">
            {{ $voteSet->anonymous ? '無記名' : '記名' }}
        </h6>
        <div class="card-body">
            投票者数: {{ $voteSet->histories()->count() }}
        </div>
    </div>
    @if ($voteSet->items()->count())
    @foreach ($voteSet->items()->orderBy('seq')->get() as $item)
    <h6>{{ $item->name }}</h6>
    <ul>
        @php
        $count = 0
        @endphp
        @foreach (explode("\n", $item->options) as $option)
        <li>
            {{ trim($option) }}: {{ $item->votes()->where('vote', trim($option))->count() }}
        </li>
        @php
        $count += $item->votes()->where('vote', trim($option))->count()
        @endphp
        @endforeach
        <li class="text-info">計: {{ $count }}</li>
    </ul>
    @endforeach
    @elseif (!$voteSet->anonymous)
        @foreach ($voteSet->histories()->orderBy('created_at')->get() as $history)
        <div>{{ $history->user_name }}</div>
        @endforeach
    @else
    @endif
</x-layout>
