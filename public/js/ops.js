function rem_res(ev) {
    let base_url = $('meta[name="site_url"]').attr("content");
    let data = $(this).attr("value");
    let values = data.split("_");
    let test_code = values[0];
    let category= values[1];
    let sid= values[2];
    let count= values[3];
    $.ajax({
        url: base_url + "/test_result/delete",
        method: "GET",
        data: { test_code: test_code, category: category, student_id: sid },
        beforeSend: function () {
            if (confirm("Are you sure you want to delete student "+sid+" result for test: "+test_code))
                return true;
            else return false;
        },
        success: function (data, status, error) {
            if(data.status==true)
            {
                alert(data.message);
                $("#tr_" + count).remove();
            }
            else{
                alert(data.message);
            }
        },
    });
    ev.preventDefault();
}


$("body").on("click", "#rem_res_btn", rem_res);
