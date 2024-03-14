@extends('admin-panel.layouts.layout_main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Əsas Menyu</h4>
            </div>
        </div>
    </div>
    <div class="row">
        {{-- <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <a href="{{ route('admin.menu.create') }}" class="btn btn-danger mb-2"><i
                                    class="mdi mdi-plus-circle me-2"></i> Əsas Menyu əlavə et</a>
                        </div>
                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col --> --}}
        <div class="col-12">
            <table class="table table-striped table-centered mb-0">
                <thead>
                    <tr>
                        <th style="width: 100px">#</th>
                        <th>Name</th>
                        <th style="width: 150px">Action</th>
                        <th style="width: 100px"></th>
                    </tr>
                </thead>
                <tbody id="sortable-tbody" data-route="{{ route('admin.menu.sort') }}">
                    @foreach ($menues as $menu)
                        <tr data-id="{{ $menu->id }}" data-order="{{ $menu->order }}">
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $menu->getTranslate->first()->title }}</td>
                            <td class="table-action d-flex" style="height: 70px">
                                <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn btn-success me-1"> <i
                                        class="mdi mdi-square-edit-outline"></i></a>
                                <a class="btn btn-danger" href="{{ route('admin.menu.delete', $menu->id) }}"
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
