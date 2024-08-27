@extends('main')

@section('content')
<h1>Customers</h1>
<div>
    <a class="btn btn-primary" href="/customers/new">Add new</a>
</div>
<table class="table table-responsive">
    <thead>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Age</th>
        <th>Birthday</th>
        <th>Created</th>
        <th>Action</th>
    </thead>
    <tbody id="clist">
        
    </tbody>
</table>
@endsection

@section('js')
<script type="text/javascript">
(function($){

    init();

    function init(){
        load_list();
        
        // DELETE
        $('table').on('click', '.delete', function(evt){
            const id = $(this).data('id');
            $.ajax({
                method: "DELETE",
                url: `/api/customers/${id}`,
                success: function(){
                    load_list();
                }
            });
        });

    }

    function load_list(){
        $.ajax({
            method: "GET",
            url: '/api/customers',
            success: function(response){
                const { data: {resultset} } = response;
                console.log(resultset);
                let row = "";
                for(let i=0; i < resultset.length; i++){
                    row += "<tr>";
                    row += `<td>${resultset[i].first_name}</td>`;
                    row += `<td>${resultset[i].last_name}</td>`;
                    row += `<td>${resultset[i].email}</td>`;
                    row += `<td>${resultset[i].age}</td>`;
                    row += `<td>${resultset[i].dob}</td>`;
                    row += `<td>${resultset[i].created_at}</td>`;
                    row += `<td><a class="btn btn-info" href="/customers/${resultset[i].id}/edit">Edit</a>&nbsp;&nbsp;<a href="javascript:void(0);" data-id="${resultset[i].id}" class="delete btn btn-danger">Delete</a></td>`;
                    row += "</tr>";
                }
                $("#clist").html(row);
            },
            error: function(xhr, status, thrown){
                console.log(xhr);
            }
        });
    }

})(jQuery);
</script>
@endsection