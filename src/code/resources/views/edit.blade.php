@extends('main')

@section('content')
<h1>Edit</h1>
@include('inputs')
<div>
    <a href="/customers" class="btn btn-success">Back</a>
    <button id="update" class="btn btn-primary">Update</button>
</div>
@endsection

@section('js')
<script type="text/javascript">
(function($){
    let id = null;
    init();

    function init(){
        load_data();
        
        // UPDATE
        $('html').on('click', '#update', function(evt){

            let html = $('html');
            if (id) {
                $.ajax({
                    method: "PUT",
                    url: `/api/customers/${id}`,
                    data: {
                        first_name: html.find('#first_name').val(),
                        last_name: html.find('#last_name').val(),
                        email: html.find('#email').val(),
                        age: html.find('#age').val(),
                        birthday: html.find('#birthday').val(),
                    },
                    success: function(){
                        window.location.href = '/customers';
                    }
                });
            } else {
                alert("Cannot update. Record does not exist.");
            }
            
        });
        
    }

    function load_data(){
        let pathname = window.location.pathname;
        pathname = pathname.split("/").filter(function(value) {
            return value !== null && value !== undefined && value !== '';
        });

        id = parseInt(pathname[1]);
        
        $.ajax({
            method: "GET",
            url: `/api/customers/${id}`,
            success: function(response){
                const { result } = response;
                $('#first_name').val(result.first_name);
                $('#last_name').val(result.last_name);
                $('#email').val(result.email);
                $('#age').val(result.age);
                $('#birthday').val(result.dob);
                
            },
            error: function(xhr, status, thrown){
                alert("Error fetch data.");
                console.error(xhr);
            }
        });
    }

})(jQuery);
</script>
@endsection