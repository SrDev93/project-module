@extends('layouts.admin')

@push('stylesheets')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"/>
@endpush

@section('content')
    <!-- CONTAINER -->
    <div class="main-container container-fluid">
        <!-- PAGE-HEADER -->
    @include('project::partial.header')
    <!-- PAGE-HEADER END -->

        <!-- ROW -->
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h3 class="card-title">ویرایش پروژه</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('project.update', $project->id) }}" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                            <div class="col-md-6">
                                <label for="title" class="form-label">عنوان</label>
                                <input type="text" name="title" class="form-control" id="title" required value="{{ $project->title }}">
                                <div class="invalid-feedback">لطفا عنوان را وارد کنید</div>
                            </div>
                            <div class="col-md-6">
                                <label for="slug" class="form-label">نامک</label>
                                <input type="text" name="slug" class="form-control" id="slug" required value="{{ $project->slug }}">
                                <div class="invalid-feedback">لطفا نامک را وارد کنید</div>
                            </div>
                            <div class="col-md-5">
                                <label for="image" class="form-label">تصویر شاخص</label>
                                <input type="file" name="image" class="form-control" aria-label="تصویر شاخص" id="image" accept="image/*">
                                <div class="invalid-feedback">لطفا یک تصویر انتخاب کنید</div>
                            </div>
                            <div class="col-md-1">
                                @if($project->image)
                                    <a href="{{ url($project->image) }}" data-fancybox><img src="{{ url($project->image) }}" style="max-width: 50%;"></a>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="date" class="form-label">تاریخ اجرا</label>
                                <input type="text" name="date" class="form-control date" id="date" value="{{ $project->date }}" required>
                                <div class="invalid-feedback">لطفا تاریخ اجرا را وارد کنید</div>
                            </div>
                            <div class="col-md-6">
                                <label for="manager" class="form-label">مسئول پروژه</label>
                                <input type="text" name="manager" class="form-control" id="manager" value="{{ $project->manager }}">
                                <div class="invalid-feedback">لطفا نام مسئول پروژه را وارد کنید</div>
                            </div>
                            <div class="col-md-6">
                                <label for="construct_status" class="form-label">وضعیت پروژه</label>
                                <select name="construct_status" class="form-control">
                                    <option value="0" @if($project->construct_status == 0) selected @endif>در حال ساخت</option>
                                    <option value="1" @if($project->construct_status == 1) selected @endif>ساخته شده</option>
                                </select>
                                <div class="invalid-feedback">لطفا وضعیت پروژه را انتخاب کنید</div>
                            </div>


                            <div class="col-md-12">
                                <label for="manager" class="form-label">توضیحات پروژه</label>
                                <textarea id="editor1" name="description" class="cke_rtl">{{ $project->description }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label for="manager" class="form-label">تصاویر گالری</label>
                                <button type="button" class="add-gallery btn btn-primary">افزودن تصویر گالری</button>
                            </div>
                            <div class="col-md-12">
                                <div class="galleries">
                                    @foreach($project->photo as $photo)
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label for="photo" class="form-label">تصویر گالری</label>
                                                <input type="file" name="photo[]" class="form-control" aria-label="تصویر گالری" accept="image/*">
                                                <div class="invalid-feedback">لطفا یک تصویر انتخاب کنید</div>
                                            </div>
                                            <div class="col-md-1">
                                                @if($photo->path)
                                                    <a href="{{ url($photo->path) }}" data-fancybox="gallery"><img src="{{ url($photo->path) }}" style="max-width: 50%"></a>
                                                @endif
                                            </div>
                                            <div class="col-md-5">
                                                <label for="alt" class="form-label">متن جایگزین تصویر</label>
                                                <input type="text" name="alt[]" class="form-control" value="{{ $photo->alt }}">
                                                <div class="invalid-feedback">لطفا متن جایگزین تصویر را وارد کنید</div>
                                            </div>
                                            <div class="col-md-1">
                                                <a href="{{ route('project.photo.destroy', $photo->id) }}" class="btn btn-danger" onclick="return confirm('برای حذف اطمینان دارید؟');">حذف تصویر</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">بروزرسانی</button>
                                @csrf
                                @method('PATCH')
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ROW CLOSED -->


    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
        @include('ckfinder::setup')
        <script>
            var editor = CKEDITOR.replace('editor1', {
                // Define the toolbar groups as it is a more accessible solution.
                toolbarGroups: [
                    {
                        "name": "basicstyles",
                        "groups": ["basicstyles"]
                    },
                    {
                        "name": "links",
                        "groups": ["links"]
                    },
                    {
                        "name": "paragraph",
                        "groups": ["list", "blocks"]
                    },
                    {
                        "name": "document",
                        "groups": ["mode"]
                    },
                    {
                        "name": "insert",
                        "groups": ["insert"]
                    },
                    {
                        "name": "styles",
                        "groups": ["styles"]
                    },
                    {
                        "name": "about",
                        "groups": ["about"]
                    },
                    {   "name": 'paragraph',
                        "groups": ['list', 'blocks', 'align', 'bidi']
                    }
                ],
                // Remove the redundant buttons from toolbar groups defined above.
                removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
            });
            CKFinder.setupCKEditor( editor );
        </script>

        <script>
            kamaDatepicker('date');

            $('.add-gallery').click(function (){
                $('.galleries').append('<div class="row">' +
                    '<div class="col-md-6">' +
                    '<label for="photo" class="form-label">تصویر گالری</label>' +
                    '<input type="file" name="photo[]" class="form-control" aria-label="تصویر گالری" accept="image/*">' +
                    '<div class="invalid-feedback">لطفا یک تصویر انتخاب کنید</div>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label for="alt" class="form-label">متن جایگزین تصویر</label>' +
                    '<input type="text" name="alt[]" class="form-control">' +
                    '<div class="invalid-feedback">لطفا متن جایگزین تصویر را وارد کنید</div>' +
                    '</div>' +
                    '</div>');
            });
        </script>
    @endpush
@endsection
