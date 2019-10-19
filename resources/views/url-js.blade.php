"use strict";
var page = require('webpage').create();

page.settings.userAgent = 'Mozilla/5.0 (Windows NT 10.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36';
page.settings.javascriptEnabled = true;
page.settings.loadImages = false;
phantom.cookiesEnabled = false;
phantom.javascriptEnabled = true;

page.viewportSize = { width: '{{ $windowSize->width }}', height: '{{ $windowSize->height }}' };

@if(!is_null($proxy))
    phantom.setProxy('{{ $proxy->ip }}', '{{ $proxy->port }}', '{{ $proxy->schema }}', '{{ $proxy->login }}', '{{ $proxy->password }}');
@endif
page.open('{{ $url }}', function (status) {
    if (status !== 'success') {
        console.log('[status:' + status + ']');
    } else {
        console.log(page.content);
        console.log('[status:' + status + ']');
    }

    window.setTimeout(function () {
        phantom.exit();
    }, Math.random()*1000 + 1500);
});

