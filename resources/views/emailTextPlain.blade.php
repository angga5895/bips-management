@if( $type === 'password')
    Dear {{ $name }}, Here is your new account {{ $type }} that you need to login to account {{ $account }} : {{ $newpassword }}
@else
    Dear {{ $name }}, Here is your new account {{ $type }} that you need to the trading proccess to account {{ $account }} : {{ $newpassword }}
@endif