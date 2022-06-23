@extends('layouts.master')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add Users</h1>
        <a href="{{route('users.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')
   
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New User</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('users.store')}}">
                @csrf
                <div class="form-group row">

                    {{-- Name --}}
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <span style="color:red;">*</span>Name</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('name') is-invalid @enderror" 
                            id="exampleName"
                            placeholder="Name" 
                            name="name" 
                            value="{{ old('name') }}">

                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>


                    {{-- Email --}}
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <span style="color:red;">*</span>Email</label>
                        <input type="text" 
                            class="form-control form-control-user @error('email') is-invalid @enderror" 
                            id="exampleEmail"
                            placeholder="Email" 
                            name="email" 
                            value="{{ old('email') }}">

                        @error('email')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-sm-12 mb-3 mb-sm-0">
                        <label><span style="color:red;">*</span>Roles</label>
                        <div class="flex flex-wrap justify-start mb-4">
                          @foreach ($roles as $role)
                            <label class="inline-flex items-center mr-6 my-2 text-sm" style="flex: 1 0 20%;">
                              <input
                                type="radio"
                                class="form-checkbox h-4 w-4"
                                name="roles"
                                value="{{$role->id}}"
                              >
                              <span class="ml-2 {!! $role->assigned && !$role->isRemovable ? 'text-gray-600' : '' !!}">
                                {{$role->display_name ?? $role->name}}
                              </span>
                            </label>
                          @endforeach
                        </div>
                    </div>

                    @if ($permissions)
                    <div class="col-sm-12 mb-3 mb-sm-0">
                        <label><span style="color:red;">*</span>Permissions</label>

                      <div class="flex flex-wrap justify-start mb-4">
                        @foreach ($permissions as $permission)
                          <label class="inline-flex items-center mr-6 my-2 text-sm" style="flex: 1 0 20%;">
                            <input
                              type="checkbox"
                              class="form-checkbox h-4 w-4"
                              name="permissions[]"
                              value="{{$permission->getKey()}}"
                            >
                            <span class="ml-2">{{$permission->display_name ?? $permission->name}}</span>
                          </label>
                        @endforeach
                      </div>
                    </div>
                    @endif

                </div>

                {{-- Save Button --}}
                <button type="submit" class="btn btn-success btn-user btn-block">
                    Save
                </button>

            </form>
        </div>
    </div>

</div>


@endsection