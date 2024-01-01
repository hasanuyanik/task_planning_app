<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </head>
    <body class="antialiased">
        <div class="container">
            
            @foreach ($data as $dt)
                @foreach ($dt as $key => $week)
                <div class="row">
                    <div class="col shadow mb-2 p-2">
                        <div class="row">
                            <div class="col bg-success text-white p-2 m-1 mb-2 shadow">{{ $key }}</div>
                        </div>
                        <div class="row">
                        @foreach ($week as $dayParent)
                            <div class="col m-1">
                            @foreach ($dayParent as $key => $day)
                                <div class="row">
                                    <div class="col bg-success-subtle">{{ $key }}</div>
                                </div>
                                
                                    
                                @foreach ($day as $devParent)
                                    
                                        @foreach ($devParent as $key => $dev)
                                    <div class="row">
                                        <div class="col border mb-2">
                                            <div class="row">
                                                <div class="col bg-dark-subtle text-end">Developer :</div>
                                                <div class="col bg-dark-subtle">{{ $key }}</div>
                                            </div>
                                            @foreach ($dev as $taskParent)
                                                <div class="row">
                                                    <div class="col shadow-sm mt-1 mb-1">
                                                @foreach ($taskParent as $key => $task)
                                                    <div class="row" style="font-size: 12px;">
                                                        <div class="col pb-1 text-end">{{ $key }}:</div>
                                                        <div class="col pb-1">{{ $task }}</div>
                                                    </div>
                                                @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                        @endforeach
                                @endforeach
                                    
                                
                            @endforeach
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            @endforeach
            
        </div>
    </body>
</html>
