@extends('backEnd.master')
@section('mainContent')
    @push('css')
    @endpush
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('front_settings.aboutSections')</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                    <a href="#">@lang('front_settings.front_settings')</a>
                    <a href="#">@lang('front_settings.aboutSections')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            @if(isset($edit_abouts))
                @if(userPermission(520))
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                            <a href="{{route('header-about-section')}}" class="primary-btn small fix-gr-bg">
                                <span class="ti-plus pr-2"></span>
                                @lang('common.add')
                            </a>
                        </div>
                    </div>
                @endif
            @endif
        </div>
        <div class="row">
            <div class="col-lg-5">
                <div class="row ">
                    <div class="col-lg-12 ">
                        <div class="main-title">
                            <h3 class="mb-30">@if(isset($edit_abouts))
                                    @lang('front_settings.aboutSectionsEdit')
                                @else
                                    @lang('front_settings.aboutSectionsAdd')
                                @endif

                            </h3>
                        </div>
                        @if(isset($edit_abouts))
                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'update-about-section',
                            'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'add-income-update']) }}
                        @else
                            @if(userPermission(520))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'store-about-section',
                                'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'add-income']) }}
                            @endif
                        @endif
                        <div class="white-box " style="border: 1px solid rgba(51,51,51,0.25)">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                   type="text" name="title" autocomplete="off"
                                                   value="{{isset($edit_abouts)? $edit_abouts->title: old('title')}}">
                                            <input type="hidden" name="id" value="{{isset($edit_abouts)? $edit_abouts->id: old('id')}}">
                                            <label>@lang('common.title') <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('title'))
                                                <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-25">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <textarea class="primary-input form-control" cols="0" rows="4"
                                                      name="description">{{isset($edit_abouts)? $edit_abouts->description: old('description')}}</textarea>
                                            <label>@lang('common.description') *<span></span></label>
                                            <span class="focus-border textarea"></span>
                                            @if ($errors->has('description'))
                                                <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row no-gutters input-right-icon mt-25">
                                    <div class="col">
                                        <div class="row no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="input-effect">
                                                    <input class="primary-input" type="text" id="placeholderFileOneName"
                                                           placeholder="" readonly>
                                                    <span class="focus-border"></span>
                                                    @if ($errors->has('image'))
                                                        <span class="invalid-feedback d-block" role="alert">
                                                			<strong>{{ $errors->first('image') }}</strong>
                                           				 </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button class="primary-btn-small-input" type="button">
                                                    <label class="primary-btn small fix-gr-bg"
                                                           for="document_file_1">@lang('common.browse')</label>
                                                    <input type="file" class="d-none" name="image" id="document_file_1">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $tooltip = "";
                                    if(userPermission(520)){
                                            $tooltip = "";
                                        }else{
                                            $tooltip = "You have no permission to add";
                                        }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">

                                        @if(Illuminate\Support\Facades\Config::get('app.app_sync'))
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                  title="Disabled For Demo "> <button
                                                        class="primary-btn fix-gr-bg  demo_view"
                                                        style="pointer-events: none;"
                                                        type="button">@lang('front_settings.submit') </button></span>
                                        @else
                                            <button class="primary-btn fix-gr-bg" data-toggle="tooltip"
                                                    title="{{@$tooltip}}">
                                                @if(isset($edit_abouts))
                                                    @lang('common.update')
                                                @else
                                                    @lang('common.add')
                                                @endif
                                            </button>

                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="row">
                    <div class="col-lg-4 no-gutters">
                        <div class="main-title">
                            <h3 class="mb-0">@lang('front_settings.aboutSectionList')</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table id="table_id" class="display school-table " style="margin-top:20px" cellspacing="0"
                               width="100%">
                            <thead>
                            <tr>
                                <th>@lang('common.title')</th>
                                <th>@lang('front_settings.image')</th>
                                <th>@lang('common.action')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($abouts as $value)
                                <tr>
                                    <td>{{@$value->title}}</td>
                                    <td><img src="{{asset(@$value->image)}}" width="60px" height="50px"></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                @lang('common.select')
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if(userPermission(520))
                                                    <a href="{{route('details-about-section',@$value->id)}}"
                                                       class="dropdown-item small fix-gr-bg ">
                                                        @lang('common.view')
                                                    </a>
                                                @endif
                                                @if(userPermission(520))
                                                    <a class="dropdown-item"
                                                       href="{{route('edit-about-section',@$value->id)}}">@lang('common.edit')</a>
                                                @endif

                                                @if(Illuminate\Support\Facades\Config::get('app.app_sync'))
                                                    <span tabindex="0" data-toggle="tooltip" title="Disabled For Demo"> <a class="dropdown-item small fix-gr-bg  demo_view" style="pointer-events: none;">@lang('common.delete')</a></span>
                                                @else
                                                        @if(userPermission(520))
                                                            <a href="{{route('for-about-delete',@$value->id)}}" class="dropdown-item small fix-gr-bg modalLink" title="@lang('front_settings.deleteAbout')" data-modal-size="modal-md">
                                                                @lang('common.delete')
                                                            </a>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('script')
        <script>
            $(document).ready(function () {
                @if(isset($about_details))
                let data = '<div class="container-fluid">' +
                    '<div class="row">' +
                    '<div class="col-md-9">' +
                    '<h3>{{$about_details->title}}</h3>' +
                    '<h6 >{{$about_details->description}}</h6>' +
                    '</div>' +
                    '<div class="col-md-3">' +
                    '<img src="{{asset(@$about_details->image)}}" width="100px" height="100px">' +
                    ' </div>' +
                    '</div>' +
                    '</div>';
                @if($about_details!==null)
                $('#showDetaildModal').modal('show');
                @endif
                $('#modalSize').addClass('modal-lg');
                $('#showDetaildModalTile').text('@lang('front_settings.details')');
                $('#showDetaildModalBody').html(data);
                @unset($about_details);
                @endif
               $('[data-dismiss="modal"]').click(function(){
                    history.back()
                });
            });
        </script>
    @endpush
@endsection