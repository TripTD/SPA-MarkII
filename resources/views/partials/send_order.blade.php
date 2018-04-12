<div>
    <form action="{{ route('Clients.sendOrder') }}" method="POST">
        {{ csrf_field() }}
        <strong>{{ __('Name') }}</strong><input type="text" name="coustomer_name" value=""><br>
        <strong>{{ __('Contact details') }}</strong> <input type="text" name="email" value=""><br>
        <strong>{{ __('Comments') }}</strong><input type="text" name="comments" value=""><br>
        <input type="submit" name="submit" value="{{ __('Check Out!') }}">
    </form>
</div>