@extends('layouts.master')

@section('head')
    {{ __('Tech Shop Cart') }}
@endsection

@section('display-content')
    <table>

        @if (count($items) != 0)
        <tr>
            <th>{{ __('Product') }}</th>
            <th>{{ __('Title') }}</th>
            <th>{{ __('Description') }}</th>
            <th>{{ __('Price') }}</th>
        </tr>
        @else
            <p>{{ __('You have not selected items yet!') }}</p>
        @endif

        @foreach ($items as $item)
            <tr>
                <td> <img src={{ URL::asset("storage/Images/{$item->image}") }} class="ap2"> </td>
                <td> {{ $item->title }}</td>
                <td> {{ $item->description }}</td>
                <td> {{ $item->price }}</td>
                <td><a href="{{route ('Clients.removeFromCart',['id' => $item->id]) }}">{{ __('Remove item') }}</a></td>
            </tr>
        @endforeach
    </table>
@endsection

@section('links')
    <a href="{{ route('Clients.index') }}">{{ __('Go to Index!') }}</a>
@endsection

@section('footer')
    @include('partials.send_order')
@endsection
