<x-layout>
@section('title')
    <a href="{{ route('votes.index') }}">{{ $title }} </a>
@endsection
    <form method="POST" action="{{ route('votes.update', ['vote' => $voteSet->id]) }}">
        @csrf
        @method('PUT')
        <h6>{{ $voteSet->name }}</h6>
        <div class="alert alert-info" role="alert">
            <div>{{ $voteSet->anonymous ? '無記名' : '記名' }}投票です。</div>
            @if ($voteSet->items()->count())
            <div>すべての項目を選択して、「投票」ボタンを押してください。「投票」ボタンを押すと取り消すことはできません。</div>
            @else
            <div>「投票」ボタンを押してください。「投票」ボタンを押すと取り消すことはできません。</div>
            @endif
        </div>
        @foreach ($voteSet->items()->orderBy('seq')->get() as $item)
        <div class="mb-3">
            <p>{{ $item->name }}<p>
            @foreach (explode("\n", $item->options) as $option)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="item_{{ $item->id }}" value="{{ trim($option) }}" id="item_{{ $item->id }}_{{ $loop->index }}">
                <label class="form-check-label" for="item_{{ $item->id }}_{{ $loop->index }}">
                    {{ trim($option) }}
                </label>
            </div>
            @endforeach
        </div>
        @endforeach
        <div class="text-end">
            <a class="btn btn-secondary m-2" href="{{ route('votes.index') }}" role="button">
                キャンセル
            </a>
            <button class="btn btn-primary m-2" type="submit">
                <i class="bi bi-save"></i> 投票
            </button>
        </div>
    </form>
</x-layout>
