@extends('admin::layouts.master');
@section('content')
    <div id="page-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Biểu Đồ Thể Hiện Doanh Số Bán Hàng
            </h1>

        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">

                <div class="col-md-12">
                    <!-- LINE CHART -->
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">Line Chart</h3>
                        </div>
                        <div class="box-body chart-responsive">
                            <div class="chart" id="line-chart" style="height: 300px;"></div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->

                    <!-- BAR CHART -->
                    <div class="box box-success">
                        <div class="box-header">
                            <h3 class="box-title">Bar Chart</h3>
                        </div>
                        <div class="box-body chart-responsive">
                            <div class="chart" id="bar-chart" style="height: 300px;"></div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->

                </div><!-- /.col (RIGHT) -->
            </div><!-- /.row -->

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection
@section('script')
    <script type="text/javascript">
        $(function () {
            "use strict";
            //BAR CHART
            $.ajax({
                url: '/admin/baocao/all',
                type:'get',
                success:function(data){
                    var bar = new Morris.Bar({
                        element: 'bar-chart',
                        resize: true,
                        data: data,
                        barColors: ['#00a65a', '#f56954'],
                        xkey: 'Thang',
                        ykeys: ['TongTien'],
                        labels: ['Tổng Tiền'],
                        hideHover: 'auto'
                    });
                    // LINE CHART
                    var line = new Morris.Line({
                        element: 'line-chart',
                        resize: true,
                        data: data,
                        xkey: 'Thang',
                        ykeys: ['TongTien'],
                        labels: ['Tổng Tiền'],
                        lineColors: ['#3c8dbc'],
                        hideHover: 'auto'
                    });
                }
            });
        });
    </script>
@endsection

