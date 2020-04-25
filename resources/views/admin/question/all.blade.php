@if(App::isLocale('ar'))
 @php
 $lan = "admin.layouts.app_ar";
 @endphp
@else
@php
 $lan = "admin.layouts.app_en";
 @endphp
@endif
@extends($lan)
@section('title')
{{ __('question') }}
@endSection
@section("content")
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables/css/dataTables.bootstrap4.css') }}"/>
<script type="text/javascript" src="{{ asset('assets/vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="//cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
@endsection
@include('admin.layouts.messages')

@section("breadcrumb")
<section class="content-header">
    <h1>
      {{ __("question") }}
    </h1>
    <ol class="breadcrumb">
      <li><a href='{{route("home")}}'><i class="fa fa-home"></i> {{ __("home") }}</a></li>
      <li><a href='{{route("admin")}}'><i class="fa fa-dashboard"></i> {{ __("dashborad") }}</a></li>
      <li class="active"> {{ __("question") }}</li>
    </ol>
  </section>
@endsection

<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">{{ __('question') }}</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
          <i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
          <i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body" style="">
        <div class="card">


            <div class="card">


                <div class="card-body">
                        <div class="table-responsive">

                          {!! Form::open(["id"=>"form_data","url"=> route("multi_Delete_qu"),"method"=>"delete"]) !!}

                          {!! Form::hidden('_method','delete') !!}

                          {!! $dataTable->table(['class' => 'table table-striped table-bordered text-center'],true) !!}

                          {!! Form::close() !!}
                        </div>
                </div>
            </div>


        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer" style="">

        {{ $dataTable->scripts() }}
    </div>
    <!-- /.box-footer-->
  </div>




@endsection

@section("js")
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
    function check_all(){

        $('input[class="item_checked"]:checkbox').each(function(){
            if($('input[class="check_all_item"]:checkbox:checked').length == 0){
               $(this).prop("checked",false)


            }else{
                $(this).prop("checked",true);

            }
        });

    }




    $(document).on("click",".del_all",function(){



        if($('input[class="item_checked"]:checkbox:checked').length > 0){

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.value) {
                    $("#form_data").submit();
                }
              })

        }else{

            Swal.fire({
                title: 'Please chose something to delete',
                type: 'warning',
            })
        }


     });




</script>

@endsection
