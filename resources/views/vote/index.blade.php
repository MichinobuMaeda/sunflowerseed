<x-layout>
@section('title', $title)
@if (in_array('voteadmin', Request::get('account')['privs'], true))
    <div class="text-end">
        <a class="btn btn-primary" href="{{ route('votes.create') }}" role="button">
            <i class="bi bi-plus-square"></i> 新規作成
        </a>
    </div>
@endif
@foreach ($voteSets as $voteSet)
@if ($voteSet->status == 'prep')
    <h6>
        <span class="badge bg-warning">準備中</span>
        @if (in_array('voteadmin', Request::get('account')['privs'], true))
        <a href="{{ route('votes.edit', ['vote' => $voteSet->id]) }}">{{ $voteSet->name }}</a>
        @else
        {{ $voteSet->name }}
        @endif
    </h6>
@elseif ($voteSet->status == 'open')
    @if ($voteSet->histories()->where('user_id', Request::get('account')['id'])->count())
    <h6>
        <span class="badge bg-success">投票済</span>
        @if (in_array('voteadmin', Request::get('account')['privs'], true))
        <a href="{{ route('votes.edit', ['vote' => $voteSet->id]) }}">{{ $voteSet->name }}</a>
        @else
        {{ $voteSet->name }}
        @endif
    </h6>
    @else
    <h6>
        <span class="badge bg-primary">投票中</span>
        <a href="{{ route('votes.edit', ['vote' => $voteSet->id]) }}">{{ $voteSet->name }}</a>
    </h6>
    @endif
@else
    <h6>
        <span class="badge bg-secondary">終了</span>
        <a href="{{ route('votes.show', ['vote' => $voteSet->id]) }}">{{ $voteSet->name }}</a>
    </h6>
@endif
@endforeach
</x-layout>
