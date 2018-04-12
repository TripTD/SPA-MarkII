@extends('layouts.master')

@section('head')
    {{__('IT MechaTech')}}
@endsection

@section('display-content')
    <table>

        @if ($items)
            <tr>
                <th>{{ __('Product') }}</th>
                <th>{{ __('Title') }}</th>
                <th>{{ __('Description') }}</th>
                <th>{{ __('Price') }}</th>
            </tr>
        @else
            <p>{{ __('Nothing to show for the moment!') }}</p>
        @endif

        @foreach ($items as $item)
            <tr>
                <td><img class="ap2" src="{{ URL::asset("storage/Images/{$item->image}") }}"> </td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->price }}</td>
                <td><a href="{{ route('Clients.addToCart',['id' => $item->id]) }}">{{ __('Add item') }}</a></td>
            </tr>
        @endforeach

    </table>
@endsection

@section('links')
    <a href="{{ route('Clients.cart') }}">{{ __('Go to cart!') }}</a>
@endsection

@section('footer')
    @include('partials.login_div')
@endsection