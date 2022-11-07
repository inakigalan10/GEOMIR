@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ __('Places') }}</div>
               <div class="card-body">
                   <table class="table">
                       <thead>
                           <tr>
                               <td scope="col">Id</td>
                               <td scope="col">Name</td>
                               <td scope="col">Description</td>
                               <td scope="col">File_id</td>
                               <td scope="col">Latitude</td>
                               <td scope="col">Longitude</td>
                               <td scope="col">Category_id</td>
                               <td scope="col">Visibility_id</td>
                               <td scope="col">Athor_id</td>
                               <td scope="col">Created_at</td>
                               <td scope="col">Updated_at</td>
                           </tr>
                       </thead>
                       <tbody>
                           @foreach ($places as $place)
                           <tr>
                               <td>{{ $place->id }}</td>
                               <td>{{ $place->name }}</td>
                               <td>{{ $place->description }}</td>
                               <td>{{ $place->file_id }}</td>
                               <td>{{ $place->latitude }}</td>
                               <td>{{ $place->longitude }}</td>
                               <td>{{ $place->category_id }}</td>
                               <td>{{ $place->visibility_id }}</td>
                               <td>{{ $place->user->name }}</td>
                               <td>{{ $place->created_at }}</td>
                               <td>{{ $place->updated_at }}</td>
                               <td><a class="btn btn-primary" href="{{ route('places.show', $place) }}"role="button">show</a></td>
                           </tr>
                           @endforeach
                       </tbody>
                   </table>
                   <a class="btn btn-primary" href="{{ route('places.create') }}" role="button">Add new place</a>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection
