
$("ul.tree").on("click", ".expander:has(i)", function(){

    var expander = this;

    if ($(expander).find("i").hasClass("fa-plus")) {

        if ($(expander).parents("li:first").find("ul").length == 0) {

            $(expander).html("<img src='/icons/loading.gif'>");
            var employee_id = $(expander).parents("li:first").find(".display:first").attr("data-id");

            $.get({
                url: "/employees/" + employee_id + "/subtree",
                dataType: "html",
                success: function(data){
                    if (data) {
                        $(expander).parents("li:first").append(data);
                        $(expander).html("<i class='fa fa-minus'></i>");
                        $(expander).parents("li:first").find("ul").eq(0).slideToggle();
                    } else {
                        $(expander).html("");
                    }
                },
                error: function(){
                    $(expander).html("");
                }
            });
        } else {
            $(expander).parents("li:first").find("ul").eq(0).slideToggle();
            $(expander).find("i").removeClass("fa-plus").addClass("fa-minus");
        }

    } else {
        $(expander).parents("li:first").find("ul").eq(0).slideToggle(400, function(){
            $(expander).find("i").removeClass("fa-minus").addClass("fa-plus");
        });
    }

});

$(".employees-table-wrapper").on("click", "ul a", function(event){
    event.preventDefault();

    var data = {
        page: $(this).attr("href").split("page=")[1],
        sort_field: $(".sort:has(i)").attr("data-field"),
        sort_type: $(".sort:has(i)").attr("data-sort"),
        search_field: $("#search_employee #search_field").val(),
        search_value: $("#search_employee #search_value").val()
    };

    updateEmployeeList(data);
});

$(".employees-table-wrapper").on("click", ".sort", function(){

    if ($(this)[0].hasAttribute("data-sort")) {
        var sort_type = $(this).attr("data-sort");

        if (sort_type == 'asc') {
            sort_type = 'desc';
        } else {
            sort_type = 'asc';
        }
    } else {
        var sort_type = 'asc';
    }

    var data = {
        page: $(".pagination .active span").text(),
        sort_field: $(this).attr("data-field"),
        sort_type: sort_type,
        search_field: $("#search_employee #search_field").val(),
        search_value: $("#search_employee #search_value").val()
    };

    updateEmployeeList(data);
});

$("#search_employee").submit(function( event ) {
    event.preventDefault();

    var data = {
        search_field: $("#search_employee #search_field").val(),
        search_value: $("#search_employee #search_value").val()
    };

    updateEmployeeList(data);
});

function updateEmployeeList(data)
{
    $.get({
        url: "/employees",
        data: data,
        dataType: "html",
        success: function(data){
            if (data) {
                $(".employees-table-wrapper").html(data);
            }
        },
        error: function(){

        }
    });
}

function selectPosition(elem)
{
    var position = $(elem).val();

    if (position == -1) {
        $("#pid").attr("disabled","");
    } else {
        $.get({
            url: "/employees/get-bosses",
            data: {
                position_id: position
            },
            dataType: "html",
            success: function(data){
                if (data) {
                    $("#pid").replaceWith(data);
                }
            }
        });
    }
}
