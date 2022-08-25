    @extends('page.auth.index')
    
    @section('content')
        <div style="width: 40%;" class="m-auto my-5 p-3 shadow-lg rounded">
            <form action="{{ route('authentification/login') }}" method="POST">
                @csrf
                <h2 class="text-center text-primary mt-3">Aplikasi Persediaan</h2>
                
                <div class="w-75 m-auto">
                    <hr>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Username</label>
                        <input type="text" autocomplete="off" name="username" value="{{ old('username') }}" class="form-control" id="exampleFormControlInput1" placeholder="Username" >
                        @error('username')
                        <small class="text-danger mt-2 d-block">{{ $message }}</small>
                        @enderror
                    </div>
            
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="exampleFormControlInput1" placeholder="Password">
                        @error('password')
                        <small class="text-danger mt-2 d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    @if(Session::has('message'))
                    <div class="alert alert-danger my-4" role="alert">
                        {{ Session::get('message') }}
                    </div>
                    @endif
            
                    <button class="w-50 d-block m-auto my-4 fw-bold btn btn-primary rounded">Login</button>

                    <hr class="w-75 m-auto">
                    <small class="text-secondary text-center d-block my-3">Web App Created By Damenjo Sitepu &copy; {{ date('Y') }}</small>
                </div>
            </form>
        </div>

    @endSection