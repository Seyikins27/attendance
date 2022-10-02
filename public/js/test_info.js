function get_department_test(ev) {
    $("#category_exam").hide();
    let id = $("#test_category").val();
    let base_url = $('meta[name="site_url"]').attr("content");
    $.get(base_url + "/ajax/test/category/" + id, {}, function (
        data,
        status,
        error
    ) {
        if (data) {
            $("#category_exam").show();
            $("#category_exam").html(data);
            $(".chosen-select").chosen({ width: "50%" });
            $('.chosen-search input').attr("placeholder", "Type here to search for Tests...");
        } else {
            $("#category_exam").html(error);
        }
    });
}

function get_test_tutor(ev) {
    $("#tutors").hide();
    let id = $("#test").val();
    let base_url = $('meta[name="site_url"]').attr("content");
    $.get(base_url + "/ajax/test/tutor/" + id, {}, function (
        data,
        status,
        error
    ) {
        if (data) {
            $("#tutors").show();
            $("#tutors").html(data);
            $("#verify_btn").attr("disabled", false);
            $(".chosen-select").chosen({ width: "50%" });
            $('.chosen-search input').attr("placeholder", "Type here to search for your Tutor...");
        } else {
            $("#tutors").html(error);
        }
    });
}

function check_count(time) {
    if (time == null) {
        let base_url = $('meta[name="site_url"]').attr("content");
        window.location = base_url + "/session/not_verified";
    }
}

function countdown(elementName, minutes, seconds) {
    var element, endTime, hours, mins, msLeft, time;

    function twoDigits(n) {
        return n <= 9 ? "0" + n : n;
    }

    function updateTimer() {
        msLeft = endTime - +new Date();
        if (msLeft < 1000) {
            document.getElementById("test_form").submit();
        } else {
            time = new Date(msLeft);
            hours = time.getUTCHours();
            mins = time.getUTCMinutes();
            if (msLeft < 500000) {
                element.style.color = "red";
            }
            element.innerHTML =
                (hours ? hours + ":" + twoDigits(mins) : mins) +
                ":" +
                twoDigits(time.getUTCSeconds());
            setTimeout(updateTimer, time.getUTCMilliseconds() + 500);
        }
    }

    element = document.getElementById(elementName);
    endTime = +new Date() + 1000 * (60 * minutes + seconds) + 500;
    updateTimer();
}

function upload_file(ev)
{ 
    //alert("Clicked");
    let base_url = $('meta[name="site_url"]').attr("content");
    let rid = $('#rid').attr("value");
    let form_data=new FormData(document.getElementById("fileForm"));    
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: base_url + "/session/upload",  
        type: 'POST',
        enctype:'multipart/form-data',
        data: form_data, 
        beforeSend: function()
        {
            $('#upload_response').html("Uploading File ...");
        },
        success:function(data){
           
            console.log(typeof(data));
            console.log(data);
           
            console.log(data.status);
           
            if(data.status==true)
            {
                console.log(data.message);
                $('#upload_response').html("file Uploaded successfully");
                $('#essay_response_'+rid).val(data.message);
                $('#upload_response_'+rid).html("<i class='alert-success'>File Attached</i>");
            }
            else if(data.status==false){
                console.log(typeof(data.message));
                $('#upload_response').html(JSON.stringify(data.message));
            }
           
        },
        error:function(msg)
        {
          $('#upload_response').html(msg);
          console.log(msg);
        },
        cache: false,
        contentType: false,
        processData: false
    });
    ev.preventDefault();
}

function load_file_upload(ev) {
    let id = $(this).attr("vid");
    let base_url = $('meta[name="site_url"]').attr("content");
    let sid = $('#student_id').attr("value");
    let test_code = $('#test_code').attr("value");
    let category = $('#test_category').attr("value");
    $.get(base_url + "/session/file", {id:id, student_id:sid, test_code:test_code, test_category:category}, function (data, status, error) {
        if (data) {
            $("#modal-content").html(data);
        } else {
            $("#modal-content").html(error);
        }
    });
}


$("body").on("change", "#test_category", get_department_test);
$("body").on("change", "#test", get_test_tutor);
$("body").on("click", "#attach_file", load_file_upload);
$("body").on("click", "#upload_essay_btn", upload_file);
