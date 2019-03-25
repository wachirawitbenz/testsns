<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>AWS SNS Test</title>
    </head>
    <body>
    <h1>AWS SNS Test</h1>
        <div class = "row">
            <div>
                <a href="{{route('add.topic')}}">Create Topic</a>
            </div>
            <div>
                <a href="{{route('send.queue')}}">Publish Topic to Queue</a>
            </div>
            <div>
                <a href="{{route('receive.queue')}}">Receive Message from Queue</a>
            </div>
        </div>
    </body>
    
</html>
