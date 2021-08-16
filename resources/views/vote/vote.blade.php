<x-layout>
@section('title', $title)
    <form method="POST" action="{{ route('votes.update', ['vote' => $voteSet->id]) }}">
        @csrf
        @method('PUT')
        <h6>{{ $voteSet->name }}</h6>
        <div class="alert alert-info" role="alert">
            <div>{{ $voteSet->anonymous ? '無記名' : '記名' }}投票です。</div>
            <div>すべての項目を選択して、「投票」ボタンを押してください。「投票」ボタンを押すと取り消すことはできません。</div>
        </div>
        @foreach ($voteSet->items()->orderBy('seq')->get() as $item)
        <div class="mb-3">
            <p>{{ $item->name }}<p>
            @foreach (explode("\n", $item->options) as $option)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="options_{{ $item->seq }}" id="options_{{ $item->seq }}_{{ $loop->index }}">
                <label class="form-check-label" for="options_{{ $item->seq }}_{{ $loop->index }}">
                    {{ $option }}
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
