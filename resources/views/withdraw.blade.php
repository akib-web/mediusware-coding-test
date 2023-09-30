@extends('home')

@section("page_content")

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div>
    <form action="{{route('withdraw')}}" method="post" >
        @csrf
        <div class="form-group">
          <label for="user_id">User ID</label>
          <input min="1" type="number" name="user_id" class="form-control" id="user_id" placeholder="Enter user id">
        </div>
        <div class="form-group">
          <label for="amount">Amount</label>
          <input type="amount" name="amount" class="form-control" id="amount" placeholder="Enter Amount">
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>

@endsection
