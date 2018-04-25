@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="post" action="/posts">
{{csrf_field()}}
Name :- <input type="text" name="name" value="{{ $user->name }}">
<br><br>
Email :- 
<input type="email" name="email" value="{{ $user->email }}">
<br>
<br>
Gender:
<select class="form-control" name="gender">
@if ($user->gender === 'male')
    <option selected="selected" value="male">male</option>
    @else
    <option value="female">female</option>
    @endif
</select>

<br>
<input type="submit" value="Submit" class="btn btn-primary">
</form>

@endsection