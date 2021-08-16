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
    <h6>
        <span class="badge bg-primary">投票中</span>
        <!-- TODO: 投票管理者以外は、自分の投票が終わるとリンクが表示されなくなる。 -->
        <a href="{{ route('votes.edit', ['vote' => $voteSet->id]) }}">{{ $voteSet->name }}</a>
    </h6>
@else
    <h6>
        <span class="badge bg-secondary">[終了]</span>
        {{ $voteSet->name }}
    </h6>
@endif
@endforeach
</x-layout>
