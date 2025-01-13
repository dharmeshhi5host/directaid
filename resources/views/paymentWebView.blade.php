<html>
<head>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
</head>
<body>
<link rel="shortcut icon" href="https://goSellJSLib.b-cdn.net/v2.0.0/imgs/tap-favicon.ico"/>
<link href="https://goSellJSLib.b-cdn.net/v2.0.0/css/gosell.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

    const APP_URL = {!! json_encode(url('/api/v1')) !!};
    const csrf_token = '{{csrf_token()}}'
    const transaction_id = '{{$transaction_id}}'
    const tap_pub_key = '{{$tap_pub_key}}'
    const amount = '{{$amount}}'
    const user_amount = '{{$user_amount}}'
    const user_currency = '{{$user_currency}}'
    const name = '{{$user_name}}'
    const email = '{{$user_email}}'
    const country_code = '{{$user_country_code}}'
    const mobile_number = '{{$user_mobile_no}}'
    const merchant_id = '{{$merchant_id}}'
    const member_id = '{{$member_id}}'
</script>
<script src="https://goSellJSLib.b-cdn.net/v2.0.0/js/gosell.js" type="text/javascript"
        integrity=""></script>
<script src="{{URL::asset('assets/js/custom/paymentWebView.js')}}?v={{time()}}"></script>
</body>
</html>

