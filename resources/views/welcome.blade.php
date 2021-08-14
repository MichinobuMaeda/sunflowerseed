<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <title>{{ config('app.name') }}</title>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4 d-grid gap-2 p-3">
                    <h1 class="text-center">{{ config('app.name') }}</h1>
                    <button type="button" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> 投票
                    </button>
                </div>
            </div>
        </div>
    </body>
</html>
