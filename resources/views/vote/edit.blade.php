<x-layout>
@section('title')
    <a href="{{ route('votes.index') }}">{{ $title }} </a>
@endsection
@section('title2', '編集')
    <form method="POST" action="{{ route('votes.update', ['vote' => $voteSet->id]) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <div class="alert alert-danger" role="alert">
                <div>ステータスを変更すると元に戻すことができません。</div>
            </div>
            <div class="form-label">ステータス</div>
            <div class="form-check form-check-inline">
                @if (old('status', $voteSet->status) == 'prep')
                <input class="form-check-input" type="radio" value="prep" id="statusPrep" name="status" checked>
                @else
                <input class="form-check-input" type="radio" value="prep" id="statusPrep" name="status" disabled>
                @endif
                <label class="form-check-label" for="statusPrep">
                    準備中
                </label>
            </div>
            <div class="form-check form-check-inline">
                @if (old('status', $voteSet->status) == 'open')
                <input class="form-check-input" type="radio" value="open" id="statusOpen" name="status" checked>
                @elseif (old('status', $voteSet->status) == 'open')
                <input class="form-check-input" type="radio" value="open" id="statusOpen" name="status" disabled>
                @else
                <input class="form-check-input" type="radio" value="open" id="statusOpen" name="status">
                @endif
                <label class="form-check-label" for="statusOpen">
                    投票中
                </label>
            </div>
            <div class="form-check form-check-inline">
                @if (old('status', $voteSet->status) == 'close')
                <input class="form-check-input" type="radio" value="close" id="statusClose" name="status" checked>
                @else
                <input class="form-check-input" type="radio" value="close" id="statusClose" name="status">
                @endif
                <label class="form-check-label" for="statusClose">
                    終了
                </label>
            </div>
            @foreach ($errors->get('status') as $error)
            <div class="text-danger">{{ $error }}</div>
            @endforeach
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">名称</label>
            @if ($voteSet->status == 'prep')
            <input type="text" class="form-control" id="name" name="name" placeholder="必須項目" value="{{ old('name', $voteSet->name) }}">
            @else
            <input type="text" class="form-control" id="name" name="name" placeholder="必須項目" value="{{ old('name', $voteSet->name) }}" disabled>
            @endif
            @foreach ($errors->get('name') as $error)
            <div class="text-danger">{{ $error }}</div>
            @endforeach
        </div>
        <div class="mb-3">
            <div class="form-label">記名/無記名</div>
            <div class="form-check form-check-inline">
            @if (old('anonymous', $voteSet->anonymous ? '1' : '0') == '0')
                @if ($voteSet->status == 'prep')
                <input class="form-check-input" type="radio" value="0" id="anonymousFalse" name="anonymous" checked>
                @else
                <input class="form-check-input" type="radio" value="0" id="anonymousFalse" name="anonymous" checked disabled>
                @endif
            @else
                @if ($voteSet->status == 'prep')
                <input class="form-check-input" type="radio" value="0" id="anonymousFalse" name="anonymous">
                @else
                <input class="form-check-input" type="radio" value="0" id="anonymousFalse" name="anonymous" disabled>
                @endif
            @endif
                <label class="form-check-label" for="anonymousFalse">
                    記名
                </label>
            </div>
            <div class="form-check form-check-inline">
            @if (old('anonymous', $voteSet->anonymous ? '1' : '0') == '1')
                @if ($voteSet->status == 'prep')
                <input class="form-check-input" type="radio" value="1" id="anonymousTrue" name="anonymous" checked>
                @else
                <input class="form-check-input" type="radio" value="1" id="anonymousTrue" name="anonymous" checked disabled>
                @endif
            @else
                @if ($voteSet->status == 'prep')
                <input class="form-check-input" type="radio" value="1" id="anonymousTrue" name="anonymous">
                @else
                <input class="form-check-input" type="radio" value="1" id="anonymousTrue" name="anonymous" disabled>
                @endif
            @endif
                <label class="form-check-label" for="anonymousTrue">
                    無記名
                </label>
            </div>
            @foreach ($errors->get('anonymous') as $error)
            <div class="text-danger">{{ $error }}</div>
            @endforeach
        </div>
        @if ($voteSet->status == 'prep')
        <div class="alert alert-warning" role="alert">
            <div>項目名または選択肢が空欄の場合、その項目は削除します。</div>
        </div>
        <div class="alert alert-info" role="alert">
            <div>選択肢は改行区切りで記入してください。</div>
        </div>
        @endif
        @foreach ($voteSet->items()->orderBy('seq')->get() as $item)
        <div class="mb-3">
            <label for="item_name_{{$item->id}}" class="form-label">項目名{{$loop->index + 1}}</label>
            @if ($voteSet->status == 'prep')
            <input type="text" class="form-control" id="item_name_{{$item->id}}" name="item_name[]" value="{{ old('item_name.'.$loop->index, $item->name) }}">
            @else
            <input type="text" class="form-control" id="item_name_{{$item->id}}" name="item_name[]" value="{{ old('item_name.'.$loop->index, $item->name) }}" disabled>
            @endif
        </div>
        <div class="mb-3">
            <label for="item_options_{{$item->id}}" class="form-label">選択肢{{$loop->index + 1}}</label>
            @if ($voteSet->status == 'prep')
            <textarea class="form-control" id="item_options_{{$item->id}}" name="item_options[]" rows="3">{{ old('item_options.'.$loop->index, $item->options) }}</textarea>
            @else
            <textarea class="form-control" id="item_options_{{$item->id}}" name="item_options[]" rows="3" disabled>{{ old('item_options.'.$loop->index, $item->options) }}</textarea>
            @endif
        </div>
        @endforeach
        @if ($voteSet->status == 'prep')
        <div class="mb-3">
            <label for="item_name_new" class="form-label">項目名{{$voteSet->items()->count() + 1}}</label>
            <input type="text" class="form-control" id="item_name_new" name="item_name[]" value="{{ old('item_name_new') }}">
        </div>
        <div class="mb-3">
            <label for="item_options_new" class="form-label">選択肢{{$voteSet->items()->count() + 1}}</label>
            <textarea class="form-control" id="item_options_new" name="item_options[]" rows="3">{{ old('item_options_new') }}</textarea>
        </div>
        @endif
        <div class="text-end">
            <a class="btn btn-secondary m-2" href="{{ route('votes.index') }}" role="button">
                キャンセル
            </a>
            <button class="btn btn-primary m-2" type="submit">
                <i class="bi bi-save"></i> 保存
            </button>
        </div>
    </form>
</x-layout>
