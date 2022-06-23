@extends('layouts.master')

@section('title', 'Permissions')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Permissions</h1>
    <a
      href="{{route('laratrust.permissions.create')}}"
      class="self-end bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
    >
      + New Permission
    </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Permissions</h6>
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th class="th">Id</th>
              <th class="th">Name/Code</th>
              <th class="th">Slug</th>
              <th class="th"></th>
            </tr>
          </thead>
          <tbody class="bg-white">
            @foreach ($permissions as $permission)
            <tr>
              <td class="td text-sm leading-5 text-gray-900">
                {{$permission->getKey()}}
              </td>
              <td class="td text-sm leading-5 text-gray-900">
                {{$permission->name}}
              </td>
              <td class="td text-sm leading-5 text-gray-900">
                {{$permission->slug}}
              </td>
              <td>
                <a class="btn btn-primary" href="{{url('permissions')}}/{{$permission->id}}/edit">Edit</a>
                <a class="btn btn-danger">Delete</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

            </div>
        </div>
    </div>
  </div>

  </div>
@endsection