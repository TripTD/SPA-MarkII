@extends('layouts.master')

@section('head')
    {{ __('Edditing/Insertion of Products') }}
@endsection

@section('display-content')

    @if (count($errors) > 0)
        <div class = "alert alert-danger">
            <p>{{ __('Something went wrong! See below what!') }}</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('product.store', ['id' => $id]) }}"  method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <strong>{{ __('Title') }}</strong> <input type="text" name="Title" value=""/><br/>
        <strong>{{ __('Description') }}</strong> <input type="text" name="Description" value=""/><br/>
        <strong>{{ __('Price') }}</strong> <input type="number" name="Price" value=""/><br/>
        <strong>{{ __('Image') }}</strong> <input type="file" name="Image">
        <input type="submit" name="submit" value="{{ __('Submit') }}">
    </form>
@endsection
