            <div class="col-sm-12 col-lg-6">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Contest {{ '(' . session()->get('eventCount') . ')' }}</h4>
                        </div>
                        <div class="iq-header-title">
                            <h4 class="card-title"> <a href="{{ route('event.result') }}">Contest Result</a></h4>
                        </div>
                        <div class="iq-header-title">
                            <h4 class="card-title"> <a href="{{ route('event.create') }}">Create Contest</a></h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <table id="user-list-table" class="table table-striped table-bordered mt-1" role="grid"
                            aria-describedby="user-list-page-info">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($eventlist as $list)
                                    <tr>
                                        <td>{{ $list->name }}</td>
                                        <td>{{ $list->date }}</td>
                                        <td>{{ $list->status }}</td>
                                        <td>{{ $list->price }}</td>
                                        <td>
                                            <div class="iq-card-header-toolbar d-flex align-items-center">
                                                <div class="dropdown">
                                                    <span class="dropdown-toggle text-primary" id="dropdownMenuButton5"
                                                        data-toggle="dropdown">
                                                        <a href="" class="align-items-center"><i
                                                                class="ri-more-fill"></i></a>
                                                    </span>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                        aria-labelledby="dropdownMenuButton5">
                                                        <a class="dropdown-item" href="{{ route('event.show', $list->id) }}"><i
                                                                class="ri-eye-fill mr-2"></i>View</a>
                                                        {{-- <a class="dropdown-item" href="/event/{{ $list->id }}"><i
                                                                class="ri-eye-fill mr-2"></i>View</a> --}}
                                                        <a class="dropdown-item" href="{{ route('event.edit', $list->id) }}"><i
                                                                class="ri-pencil-fill mr-2"></i>Edit</a>
                                                        <form method="POST" action="{{ route('event.delete', $list->id) }}">
                                                            @csrf
                                                            @method('delete')
                                                            <button href="" class="dropdown-item"><i
                                                                    class="ri-delete-bin-6-fill mr-2"></i>Delete</button>
                                                        </form>
                                                        <a class="dropdown-item" href="/e-syllabus/{{ $list->id }}"><i
                                                                class="ri-eye-fill mr-2"></i>Syllabus</a>
                                                        <a class="dropdown-item" href="/e-question/{{ $list->id }}"><i
                                                                class="ri-eye-fill mr-2"></i>Question</a>
                                                        <a class="dropdown-item" href="{{ route('admin.result', $list->id) }}"><i
                                                                class="ri-eye-fill mr-2"></i>Result</a>
                                                        <a class="dropdown-item" href="{{ route('admin.participant', $list->id) }}"><i
                                                                class="ri-eye-fill mr-2"></i>Participant</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="">
                            {{ $eventlist->links() }}
                        </div>
                    </div>
                </div>
            </div>