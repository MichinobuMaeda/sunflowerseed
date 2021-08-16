<x-layout>
@section('title', $title)
    <form method="POST" action="{{ route('votes.store') }}">
        @csrf
        <div class="alert alert-info" role="alert">
            <div>名称、記名/無記名、項目数は後で変更できます。</div>
            <div>選択肢は後で項目毎に変更できます。候補者名等を設定することも可能です。</div>
            <div>出席確認は「記名」で項目数 0 としてください。</div>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">名称</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="必須項目" value="{{ old('name') }}">
            @foreach ($errors->get('name') as $error)
            <div class="text-danger">{{ $error }}</div>
            @endforeach
        </div>
        <div class="mb-3">
            <div class="form-label">記名/無記名</div>
            <div class="form-check form-check-inline">
                @if (old('anonymous', '1') == '0')
                <input class="form-check-input" type="radio" value="0" id="anonymousFalse" name="anonymous" checked>
                @else
                <input class="form-check-input" type="radio" value="0" id="anonymousTrue" name="anonymous">
                @endif
                <label class="form-check-label" for="anonymousFalse">
                    記名
                </label>
            </div>
            <div class="form-check form-check-inline">
                @if (old('anonymous', '1') == '1')
                <input class="form-check-input" type="radio" value="1" id="anonymousTrue" name="anonymous" checked>
                @else
                <input class="form-check-input" type="radio" value="1" id="anonymousTrue" name="anonymous">
                @endif
                <label class="form-check-label" for="anonymousTrue">
                    無記名
                </label>
            </div>
            @foreach ($errors->get('anonymous') as $error)
            <div class="text-danger">{{ $error }}</div>
            @endforeach
        </div>
        <div class="mb-3">
            <label for="item_count" class="form-label">項目数</label>
            <input type="number" class="form-control" id="item_count" name="item_count" value="{{ old('item_count', 0) }}">
            @foreach ($errors->get('item_count') as $error)
            <div class="text-danger">{{ $error }}</div>
            @endforeach
        </div>
        <div class="mb-3">
            <div class="form-label">選択肢</div>
            <div class="form-check">
                @if (old('item_options', '0') == '0')
                <input class="form-check-input" type="radio" value="0" id="item_options0" name="item_options" checked>
                @else
                <input class="form-check-input" type="radio" value="0" id="item_options0" name="item_options">
                @endif
                <label class="form-check-label" for="item_options0">
                    賛成/反対/保留
                </label>
            </div>
            <div class="form-check">
                @if (old('item_options', '0') == '0')
                <input class="form-check-input" type="radio" value="1" id="item_options1" name="item_options">
                @else
                <input class="form-check-input" type="radio" value="1" id="item_options1" name="item_options" checked>
                @endif
                <label class="form-check-label" for="item_options1">
                    信任/不信任
                </label>
            </div>
            @foreach ($errors->get('item_options') as $error)
            <div class="text-danger">{{ $error }}</div>
            @endforeach
        </div>
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
