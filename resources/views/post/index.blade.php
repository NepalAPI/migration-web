@extends('layouts.master')

@section('content')

    <h1>Posts <a href="{{ route('post.create') }}" class="btn btn-primary pull-right btn-sm">Add New Post</a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Title</th>
                    <th>Stage</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @forelse($posts as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td><a href="{{route('post.show',$item->id)}}">{{ $item->metadata->title }}</a>
                        <span class="label label-info pull-right">{{$item->metadata->type}}</span>
                    </td>
                    <td>
                        @foreach($item->metadata->stage as $stage)
                        {{ $stage }}<br>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('post.edit', $item->id) }}">
                            <button type="submit" class="btn btn-primary btn-xs">Update</button>
                        </a> /
                        {!! Form::open([
                            'method'=>'DELETE',
                            'route' => ['post.destroy', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @empty
                    <tr><td colspan="4" align="center"> No Posts Available.</td></tr>
            @endforelse
            </tbody>
        </table>
        <div class="pagination"> {!! $posts->render() !!} </div>
    </div>

@endsection
