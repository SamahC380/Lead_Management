<table class="table table-dark table-striped table-hover table-bordered w-100 text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Lead Name</th>
                    <th>Contact Type</th>
                    <th>Contact Details</th>
                    <th>Category</th>
                    <th>Remark</th>
                    <th>Check</th>
                    <th>Created By</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                $counter = 1;
                @endphp
                @foreach($users as $user)
                @foreach($leads as $lead)
                @if($user->id == $lead->creator_id ) 
                <tr>
                    <td>{{$counter}}</td>
                    @php
                    $counter++;
                    @endphp
                    <td>{{$lead->name}}</td>
                    <td>{{$lead->type}}</td>
                    <td>{{$lead->detail}}</td>
                    @foreach($categories as $category)
                    @if($lead->category_id == $category->id)
                    <td>{{$category->name}}</td>
                    @endif
                    @endforeach
                    <td>{{$lead->remark}}</td>
                    <td>{{$lead->check}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{ $lead->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>
                        <!-- Add actions for executives here -->
                        <a href="{{route('EditLeadPage',$lead->id)}}" class="btn btn-primary">Edit Lead</a>
                        <a href="{{route('DeleteLead',$lead->id)}}" class='btn btn-danger'>Delete Lead</a>
                    </td>
                </tr>
                @endif
                @endforeach
                @endforeach
            </tbody>
        </table>