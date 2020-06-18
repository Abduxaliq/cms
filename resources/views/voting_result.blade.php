<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Voting </title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/frontend/assets/font-awesome/css/font-awesome.min.css">
    <style>
        .header {
            font: 45px Arial;
        }

        .list *, .button * {
            border-radius: 0px;
        }
    </style>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="/frontend/assets/js/jquery-3.2.1.slim.min.js" ></script>
    <script src="/frontend/assets/js/jquery-3.2.1.min.js" ></script>
</head>
<body>
    <div class="container-fluid p-0 m-0">
        <div class="row m-0 p-0">
            @php
                $totalCount = 0;
                foreach ($votingData->answers_data as $answer) {
                    $totalCount += $answer->vote_count;
                }
            @endphp
            <h1 class="col-12 col-md-12 col-lg-12 header">{{ $votingData->text }}</h1>
            <div class="col-12 col-md-12 col-lg-12 list">
            @foreach($votingData->answers_data as $answer)
                @php
                    $percent = $answer->vote_count * 100 / $totalCount;
                @endphp
                <div class="progress mb-1 p-0" style="background-color: #17a2b878; font: 14px Arial; height: 30%;">
                    <div class="progress-bar bg-info pl-2" role="progressbar"
                         style="width: {{ round($percent, 2) }}%; padding: 0px!important"
                         aria-valuenow="{{ round($percent, 2) }}" aria-valuemin="0" aria-valuemax="100">
                        &nbsp;&nbsp;&nbsp;{{ $answer->text }} ( {{ round($percent, 2) }}% )
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
</body>
</html>