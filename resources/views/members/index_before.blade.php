@extends('../layouts/app')

@section('content')

    <ul>
        <h1 style="text-align: center">이 곳은 현지 조원소개 페이지 입니다.</h1>
        @forelse($members as $member)
            <button type="button" class="btn btn-warning" id="getRequest">member_{{ $member->id }}</button>
            <p><a href="/{{ $member->id }}">{{ $member->id }}</a></p>
            <div class="container">
                
            </div>
            <div class="row col-lg-5">
                <form id="register" action="#">
                    <!-- 토큰정보 -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    
                    <label for="firstname"></label>
                    <input type="text" id="firstname" class="form-control">

                    <label for="lastname"></label>
                    <input type="text" id="lastname" class="form-control">

                    <input type="submit" value="Register" class="btn btn-pramary">
                </form>
            </div>
            <div id="getRequestData"></div>

            <div id="postRequestData"></div>
            <!-- <script>
                var dataTable = $('#table_data').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ url('/members') }}",
                        type: "get",
                        dataSrc: "",
                    },
                    searching: true,
                    column: [
                        {data: 'name', title:'이름', name:'name'},
                        {data: 'address', title:'주소', name:'address'},
                        {data: 'phone_number', title:'전화번호', name:'phone_number'},
                        {data: 'mottoes', title:'좌우명', name:'mottoes'},
                    ],
                    "language": lang_kr,
                })
            </script> -->
            <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
            <script type="text/javascript">
                // ajax 설정

                $(document).ready(function() {
                    $('#getRequest').click(function() {
                        // alert($(this).text());
                        $.get('getRequest', function(data) {
                            $('#getRequestData').append(data);
                            console.log(data);
                        });
                    });

                    $('#register').submit(function() {
                        var fname = $('#firstname').val();
                        var lname = $('#lastname').val();
                        
                        /* $.post('register', { firstname:fname, lastname:lname }, function(data) {
                            console.log(data);
                            $('#postRequestData').html(data);
                        }); */
                        var dataString = "firstname="+fname+"lastname="+lname;
                        $.ajax({
                            headers:{
                                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "POST",
                            url: "0",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                test: dataString,
                            },
                            success: function(data) {
                                console.log(data);
                                // $('#postRequestData').html(data);
                            }
                        });
                    });

                    /* $('#member_1').click(function() {
                        $.ajax({
                            type: "POST",
                            url: "member_{{ $member->id }}",
                            data: [
                                
                            ]
                        });
                    }); */
                });
            </script>
        @empty
            <p>조원이 등록되지 않았습니다.</p>
        @endforelse
        <p style="text-align: center"><a href="{{ route('members.create') }}">멤버 자료 추가</a></p>
    </ul>
@stop