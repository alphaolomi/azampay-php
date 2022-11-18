<?php



function stub_response($name)
{
    return _stub_response(
        stub_response_body($name)
    );
}


function _stub_response($body)
{
    return new GuzzleHttp\Psr7\Response(200, [], $body);
}

function stub_response_body(string $name)
{
    $path = __DIR__ . "/stubs/$name.json";

    return file_get_contents($path);
}
