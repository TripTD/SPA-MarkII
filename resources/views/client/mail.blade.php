@extends('layouts.master')

@section('head')
    {{ __('Ordered products') }}
@endsection

@section('display-content')


    <p>{{ __('Products list desired by coustomer') }}: {{ $name }}</p>
    <p>{{ __('E-mail adress of the coustomer') }}: {{ $from }}  </p>

    <table>
        <tr>
            <th>{{ __('Product') }}</th>
            <th>{{ __('Title') }}</th>
            <th>{{ __('Description') }}</th>
            <th>{{ __('Price') }}</th>
        </tr>
        @foreach ($items as $item)
            <tr>
                <td><img src="{{ $url }}/{{ $item->image }}" style="width:150px"></td>
                <td>|{{ __('Product') }}: {{ $item->title }}</td>
                <td>|{{ __('Description') }}: {{ $item->description }}</td>
                <td>|{{ __('Price') }}: {{  $item->price }}</td>
            </tr>
        @endforeach
    </table>
    <p>{{ __('Additional information from the client') }}: {{ $comments }} </p>
@endsection


