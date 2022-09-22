@extends('layouts.admin')

@push('stylesheets')

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
                        <h3 class="card-title">افزودن پروژه</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('project.store') }}" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                            <div class="col-md-6">
                                <label for="title" class="form-label">عنوان</label>
                                <input type="text" name="title" class="form-control" id="title" required value="{{ old('title') }}">
                                <div class="invalid-feedback">لطفا عنوان را وارد کنید</div>
                            </div>
                            <div class="col-md-6">
                                <label for="slug" class="form-label">نامک</label>
                                <input type="text" name="slug" class="form-control" id="slug" required value="{{ old('slug') }}">
                                <div class="invalid-feedback">لطفا نامک را وارد کنید</div>
                            </div>
                            <div class="col-md-6">
                                <label for="image" class="form-label">تصویر شاخص</label>
                                <input type="file" name="image" class="form-control" aria-label="تصویر شاخص" id="image" accept="image/*" required>
                                <div class="invalid-feedback">لطفا یک تصویر انتخاب کنید</div>
                            </div>
                            <div class="col-md-6">
                                <label for="date" class="form-label">تاریخ اجرا</label>
                                <input type="text" name="date" class="form-control date" id="date" value="{{ old('date') }}" required>
                                <div class="invalid-feedback">لطفا تاریخ اجرا را وارد کنید</div>
                            </div>
                            <div class="col-md-6">
                                <label for="manager" class="form-label">مسئول پروژه</label>
                                <input type="text" name="manager" class="form-control" id="manager" value="{{ old('manager') }}">
                                <div class="invalid-feedback">لطفا نام مسئول پروژه را وارد کنید</div>
                            </div>
                            <div class="col-md-6">
                                <label for="construct_status" class="form-label">وضعیت پروژه</label>
                                <select name="construct_status" class="form-control">
                                    <option value="0" @if(old('construct_status') == 0) selected @endif>در حال ساخت</option>
                                    <option value="1" @if(old('construct_status') == 1) selected @endif>ساخته شده</option>
                                </select>
                                <div class="invalid-feedback">لطفا وضعیت پروژه را انتخاب کنید</div>
                            </div>


                            <div class="col-md-12">
                                <label for="manager" class="form-label">توضیحات پروژه</label>
                                <textarea id="editor1" name="description" class="cke_rtl">{{ old('description') }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label for="manager" class="form-label">تصاویر گالری</label>
                                <button type="button" class="add-gallery btn btn-primary">افزودن تصویر گالری</button>
                            </div>
                            <div class="col-md-12">
                                <div class="galleries">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="photo" class="form-label">تصویر گالری</label>
                                            <input type="file" name="photo[]" class="form-control" aria-label="تصویر گالری" accept="image/*">
                                            <div class="invalid-feedback">لطفا یک تصویر انتخاب کنید</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="alt" class="form-label">متن جایگزین تصویر</label>
                                            <input type="text" name="alt[]" class="form-control">
                                            <div class="invalid-feedback">لطفا متن جایگزین تصویر را وارد کنید</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">ارسال فرم</button>
                                @csrf
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ROW CLOSED -->


    </div>

    @push('scripts')
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
