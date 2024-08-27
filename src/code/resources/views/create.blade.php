@extends('main')

@section('content')
<h1>Add new customer</h1>
@include('inputs')
<div>
    <a href="/customers" class="btn btn-success">Back</a>
    <button id="save" class="btn btn-primary">Save</button>
</div>
@endsection

@section('js')
<script type="text/javascript">
(function($){
    
    init();

    function init(){
        
        // SAVE
        $('html').on('click', '#save', function(evt){

            let html = $('html');

            $.ajax({
                method: "POST",
                url: `/api/customers`,
                data: {
                    first_name: html.find('#first_name').val(),
                    last_name: html.find('#last_name').val(),
                    email: html.find('#email').val(),
                    age: html.find('#age').val(),
                    birthday: html.find('#birthday').val(),
                },
                success: function(){
                    window.location.href = '/customers';
                },
                error: function(xhr){
                    const { responseJSON: { message } } = xhr;
                    alert(message);
                }
            });
            
        });
        
    }

})(jQuery);
</script>
@endsection