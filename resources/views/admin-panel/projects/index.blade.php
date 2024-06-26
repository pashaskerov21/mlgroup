@extends('admin-panel.layouts.layout_main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Məhsullar</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <a href="{{ route('admin.projects.create') }}" class="btn btn-danger mb-2"><i
                                    class="mdi mdi-plus-circle me-2"></i> Məhsul əlavə et</a>
                        </div>
                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
        <div class="col-12">
            <table class="table table-striped table-centered mb-0">
                <thead>
                    <tr>
                        <th style="width: 100px">#</th>
                        <th>Başlıq</th>
                        <th>Kateqoriya</th>
                        <th>Ana səhifəyə çıxar</th>
                        <th style="width: 150px">Action</th>
                        <th style="width: 100px"></th>
                    </tr>
                </thead>
                <tbody id="sortable-tbody" data-route="{{ route('admin.projects.sort') }}">
                    @foreach ($projects as $project)
                        <tr data-id="{{ $project->id }}" data-order="{{ $project->order }}">
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $project->getTranslate->first()->title }}</td>
                            <td>{{ $project->getCategory->first()->getTranslate->first()->title }}</td>
                            <td style="width: 250px">
                                <div class="homecheck-td">
                                    <input class="homestatus-checkbox" type="checkbox" id="switch-{{ $project->id }}"
                                        data-switch="bool" data-id="{{ $project->id }}" name="home_status" value="1"
                                        @checked($project->home_status == 1 ? true : false) />
                                    <label for="switch-{{ $project->id }}" data-on-label="Hə" data-off-label="Yox"></label>
                                </div>
                            </td>
                            <td class="table-action d-flex" style="height: 70px">
                                <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-success me-1"> <i
                                        class="mdi mdi-square-edit-outline"></i></a>
                                <a class="btn btn-danger" href="{{ route('admin.projects.delete', $project->id) }}"
                                    onclick="return confirmDelete(event, this.href)">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </td>
                            <td>
                                <button class="btn btn-primary"><i class="ri-drag-move-2-line"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    @push('js')

        <script>
            $(document).ready(function() {
                $('input.homestatus-checkbox').on('change', function() {
                    var projectID = $(this).data('id');
                    var isChecked = $(this).prop('checked') ? 1 : 0;
                    $.ajax({
                        url: "{{ route('admin.projects.update-home-status') }}",
                        method: 'POST',
                        data: {
                            projectID: projectID,
                            isChecked: isChecked,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
