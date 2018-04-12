@extends('layouts.master')

@section('head')
    {{ __('Web Tech Shop Products') }}
@endsection

@section('display-content')
    <table>
        <tr>
            <th>{{ __('Product') }}</th>
            <th>{{ __('Title') }}</th>
            <th>{{ __('Description') }}</th>
            <th>{{ __('Price') }}</th>
        </tr>
        @foreach ($items as $item)
            <tr>
                <td> <img src={{ URL::asset("storage/Images/{$item->image}") }} class="ap2"> </td>
                <td> {{ $item->title }}</td>
                <td> {{ $item->description }}</td>
                <td> {{ $item->price }}</td>
                <td><a href="{{ route('product.show',['id' => $item->id]) }}">{{ __('Edit item') }}</a></td>
                <td><a href="{{ route('product.destroy', ['id' => $item->id]) }}">{{ __('Remove item') }}</a></td>
                @method('DELETE')
            </tr>
        @endforeach
    </table>
    <br>
    <a href="{{ route('product.show',['id' => 'null']) }}">{{ __('Add Item') }}</a>
@endsection

@section('footer')
    @include('partials.logout_div')
@endsection