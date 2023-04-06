@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('send-email') }}" method="POST">
        @csrf
        <div class="row flex-column">
            <div class="col-md-12">
                <select name="user_id" id="user_id" class="form-control">
                    @foreach(App\Models\User::where('id',"<>",Auth::user()->id)->get() as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12 mt-2">
                <textarea name="message" id="" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <div class="col-md-12 mt-4">
                <button class="btn btn-success w-100">
                    Send
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
