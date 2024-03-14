@extends('admin-panel.layouts.layout_main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Alt Məzmun</h4>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <a href="{{ route('admin.service-contents.create') }}" class="btn btn-danger mb-2"><i
                                    class="mdi mdi-plus-circle me-2"></i> Alt Məzmun əlavə et</a>
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
                        <th>Xidmət</th>
                        <th style="width: 150px">Action</th>
                        <th style="width: 100px"></th>
                    </tr>
                </thead>
                <tbody id="sortable-tbody" data-route="{{ route('admin.service-contents.sort') }}">
                    @foreach ($altcontents as $content)
                        <tr data-id="{{ $content->id }}" data-order="{{ $content->order }}">
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $content->getTranslate->first()->title }}</td>
                            <td>{{ $content->getService->first()->getTranslate->first()->title }}</td>
                            <td class="table-action d-flex" style="height: 70px">
                                <a href="{{ route('admin.service-contents.edit', $content->id) }}" class="btn btn-success me-1"> <i
                                        class="mdi mdi-square-edit-outline"></i></a>
                                <a class="btn btn-danger" href="{{ route('admin.service-contents.delete', $content->id) }}"
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

@endsection
