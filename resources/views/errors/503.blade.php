
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>500 - Page error</title>

    <style id="" media="all">/* thai */
        @font-face {
            font-family: 'Kanit';
            font-style: normal;
            font-weight: 200;
            src: url(/fonts.gstatic.com/s/kanit/v7/nKKU-Go6G5tXcr5aOhWzVaFrNlJzIu4.woff2) format('woff2');
            unicode-range: U+0E01-0E5B, U+200C-200D, U+25CC;
        }

        /* vietnamese */
        @font-face {
            font-family: 'Kanit';
            font-style: normal;
            font-weight: 200;
            src: url(/fonts.gstatic.com/s/kanit/v7/nKKU-Go6G5tXcr5aOhWoVaFrNlJzIu4.woff2) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
        }

        /* latin-ext */
        @font-face {
            font-family: 'Kanit';
            font-style: normal;
            font-weight: 200;
            src: url(/fonts.gstatic.com/s/kanit/v7/nKKU-Go6G5tXcr5aOhWpVaFrNlJzIu4.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        /* latin */
        @font-face {
            font-family: 'Kanit';
            font-style: normal;
            font-weight: 200;
            src: url(/fonts.gstatic.com/s/kanit/v7/nKKU-Go6G5tXcr5aOhWnVaFrNlJz.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
    </style>

    <link type="text/css" rel="stylesheet"
          href="{{ asset('error/font-awesome.min.css') }}"/>

    <link type="text/css" rel="stylesheet" href="{{ asset('error/error.css') }}"/>

</head>
<body>
<div id="notfound">
    <div class="notfound">
        <div class="notfound-404">
            <h1>503</h1>
        </div>
        <h2>Page error</h2>
        <p>
            It seems that page you are looking for no longer exists.<br>
            Try searching again!</p>
        <p><a
                    href="{{url('/')}}">Return to homepage</a></p>
    </div>
</div>
</body>
</html>
