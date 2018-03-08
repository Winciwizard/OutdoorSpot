@extends ('master')

@section('title')

    Page d'inscription

@endsection

@section('content')
    @if(count($errors)>0)
        <div class='row'>
            <div class="col-md-4 col-md-offset-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li> {{$error}} </li>

                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <div class="row card card-body bg-light" id="form-inscription">
        <h1 >Page d'Inscription</h1>
        <br>
        <div class="col-6 ">
            <h3> Sign Up</h3>
            <form action="{{'signup'}}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control  {{$errors->has('email') ? 'is-invalid': ''}}" type="text" name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control  {{$errors->has('name') ? 'is-invalid': ''}}" type="text" name="name" id="name">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control  {{$errors->has('password') ? 'is-invalid': ''}}" type="password" name="password" id="password">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>


@endsection