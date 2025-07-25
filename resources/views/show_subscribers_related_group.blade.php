@extends('layouts.master')

@section('content')
    <div class="container">
        <h1 class="my-4">All Subscribers</h1>

        @if($relatedSubscribers->isEmpty())
            <p class="text-center text-muted" style="background-color: #f8f9fa; font-size: 1.25rem; padding: 10px; border-radius: 5px;">
                No subscribers found. Be the first to join and make a difference!
            </p>
        @else
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Group ID</th>
                    <th>Role</th>
                </tr>
                </thead>
                <tbody>
                @foreach($relatedSubscribers as $related)
                    <tr>
                        <td>{{ $related->id }}</td>
                        <td>
                            {{ $related->name }}
                            <div class="mt-2">
                                <a href="{{ route('profile', $related->id) }}" class="btn btn-info btn-sm" title="Visit Profile">
                                    <i>Visit</i>
                                </a>
                            </div>
                        </td>
                        <td>
                            @foreach ($related->groups as $group)
                                {{ $group->pivot->group_id }}
                            @endforeach
                        </td>
                        <td>
                            @switch($related->role_id)
                                @case(1)
                                Superadmin
                                @break
                                @case(2)
                                Admin
                                @break
                                @case(3)
                                Coach
                                @break
                                @case(4)
                                Trainer
                                @break
                                @default
                                Unknown
                            @endswitch
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
