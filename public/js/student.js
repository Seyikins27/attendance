function get_classroom_details(ev) {
    let base_url = $('meta[name="site_url"]').attr("content");
    let code = $('#classroom_code').val();
    $.ajax({
        url: base_url + "/student/classroom/details",
        method: "GET",
        data: { classroom_code: code },
        beforeSend: function () {
            $('#classroom_details').html('<span class="text-info">Loading response...</span>')
        },
        success: function (data, status, error) {
            if(data.status==true)
            {
                $('#classroom_details').html(data.message)
            }
            else{
                $('#classroom_details').html('<span class="text-danger">'+data.message+'</span>')
            }
        },
    });
    ev.preventDefault();
}



function enrol(ev) {
    let base_url = $('meta[name="site_url"]').attr("content");

    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: base_url + "/student/classroom/enrolment",
        method: "POST",
        data: $('#enrolment_form').serialize(),
        beforeSend: function () {
            if (confirm("Confirm Enrolment in Classroom"))
                return true;
            else return false;
        },
        success: function (data, status, error) {
            if(data.status==true)
            {
                alert(data.message);
                location.reload();
            }
            else if(data.status==false){
                $('#classroom_details').html('<span class="text-danger">'+data.message+'</span>');
            }
        },
    });
    ev.preventDefault();
}

function drop_enrolment(ev) {
    let base_url = $('meta[name="site_url"]').attr("content");
    let student=$(this).attr('data-student');
    let classroom=$(this).attr('data-classroom');
    console.log('student_id is '+student);
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: base_url + "/student/classroom/enrolment/drop",
        method: "POST",
        data: {student:student, classroom:classroom},
        beforeSend: function () {
            if (confirm("Confirm Enrolment Drop from Classroom"))
                return true;
            else return false;
        },
        success: function (data, status, error) {
            if(data.status==true)
            {
                alert(data.message);
                location.reload();
            }
            else if(data.status==false){
                alert(data.message);
                $('#classroom_details').html('<span class="text-danger">'+data.message+'</span>');
            }
        },
    });
    ev.preventDefault();
}


function signin(ev) {
    let base_url = $('meta[name="site_url"]').attr("content");
    let student=$(this).attr('data-student');
    let attendance=$(this).attr('data-att');
    var longitude=$('#lon').val();
    var latitude=$('#lat').val();

    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: base_url + "/student/attendance/signin",
        method: "POST",
        data: {student:student, attendance:attendance, longitude:longitude, latitude:latitude},
        beforeSend: function () {
            if (confirm("Confirm Signin"))
                return true;
            else return false;
        },
        success: function (data, status, error) {
            if(data.status==true)
            {
                if(data.popup==true)
                {
                    $("#modal-content").html(data.message);
                    launch_webcam(attendance);
                }
                else{
                    $("#modal-content").html("<h3>"+data.message+"</h3>");
                }

            }
            else if(data.status==false){
                $("#modal-content").html("<h3>"+data.message+"</h3>");
            }
        },
    });
    ev.preventDefault();
}


function launch_webcam(att)
{

        // The width and height of the captured photo. We will set the
        // width to the value defined here, but the height will be
        // calculated based on the aspect ratio of the input stream.

        const width = 320; // We will scale the photo width to this
        let height = 0; // This will be computed based on the input stream

        // |streaming| indicates whether or not we're currently streaming
        // video from the camera. Obviously, we start at false.

        let streaming = false;

        // The various HTML elements we need to configure or control. These
        // will be set by the startup() function.

        let video = null;
        let canvas = null;
        let photo = null;
        let startbutton = null;


        function showViewLiveResultButton() {
          if (window.self !== window.top) {
            // Ensure that if our document is in a frame, we get the user
            // to first open it in its own tab or window. Otherwise, it
            // won't be able to request permission for camera access.
            document.querySelector(".contentarea").remove();
            const button = document.createElement("button");
            button.textContent = "View live result of the example code above";
            document.body.append(button);
            button.addEventListener('click', () => window.open(location.href));
            return true;
          }
          return false;
        }

        function startup() {
          if (showViewLiveResultButton()) { return; }
          video = document.getElementById('video');
          canvas = document.getElementById('canvas');
          photo = document.getElementById('photo');
          startbutton = document.getElementById('startbutton');

          navigator.mediaDevices.getUserMedia({video: true, audio: false})
            .then((stream) => {
              video.srcObject = stream;
              video.play();
            })
            .catch((err) => {
              console.error(`An error occurred: ${err}`);
            });

          video.addEventListener('canplay', (ev) => {
            if (!streaming) {
              height = video.videoHeight / (video.videoWidth/width);

              // Firefox currently has a bug where the height can't be read from
              // the video, so we will make assumptions if this happens.

              if (isNaN(height)) {
                height = width / (4/3);
              }

              video.setAttribute('width', width);
              video.setAttribute('height', height);
              canvas.setAttribute('width', width);
              canvas.setAttribute('height', height);
              streaming = true;
            }
          }, false);

          startbutton.addEventListener('click', (ev) => {
            //add a button to verify face detection
            var show_btn=document.getElementById('verify_btn_show');
            takepicture();
            show_btn.innerHTML="";
            show_btn.innerHTML+=`<button id="capture_pic_stream" data-att="`+att+`" class="btn btn-primary">Verify Face</button>`
            ev.preventDefault();
          }, false);

          clearphoto();
        }

        // Fill the photo with an indication that none has been
        // captured.

        function clearphoto() {
          const context = canvas.getContext('2d');
          context.fillStyle = "#AAA";
          context.fillRect(0, 0, canvas.width, canvas.height);

          const data = canvas.toDataURL('image/png');
          photo.setAttribute('src', data);
        }

        // Capture a photo by fetching the current contents of the video
        // and drawing it into a canvas, then converting that to a PNG
        // format data URL. By drawing it on an offscreen canvas and then
        // drawing that to the screen, we can change its size and/or apply
        // other changes before drawing it.

        function takepicture() {
          const context = canvas.getContext('2d');
          if (width && height) {
            canvas.width = width;
            canvas.height = height;
            context.drawImage(video, 0, 0, width, height);

            const data = canvas.toDataURL('image/png');
            photo.setAttribute('src', data);
          } else {
            clearphoto();
          }
        }

        // Set up our event listener to run the startup process
        // once loading is complete.
        $("#webcamModal").on('shown.bs.modal', startup);

}

function signout(ev) {
    let base_url = $('meta[name="site_url"]').attr("content");
    let student=$(this).attr('data-student');
    let attendance=$(this).attr('data-att');
    var longitude=$('#lon').val();
    var latitude=$('#lat').val();

    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: base_url + "/student/attendance/signout",
        method: "POST",
        data: {student:student, attendance:attendance, longitude:longitude, latitude:latitude},
        beforeSend: function () {
            if (confirm("Confirm Signout"))
                return true;
            else return false;
        },
        success: function (data, status, error) {
            if(data.status==true)
            {
                alert(data.message);
                location.reload();
            }
            else if(data.status==false){
                alert(data.message);
            }
        },
    });
    ev.preventDefault();
}

function verify_face(ev)
{
    let base_url = $('meta[name="site_url"]').attr("content");
    let attendance=$(this).attr('data-att');
    let picture_stream=$('#photo').attr('src');
    console.log(picture_stream)
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: base_url + "/student/attendance/verify_face",
        method: "POST",
        data: {picture_stream:picture_stream, attendance:attendance},
        beforeSend: function () {
            $('#progress_info').innerHTML=`<span class='text-success'>Processing ..</span>`;
        },
        success: function (data, status, error) {
            if(data.status==true)
            {
                alert(data.message);
                location.reload();
            }
            else if(data.status==false){
                alert(data.message);
                location.reload();
            }
        },
    });
    ev.preventDefault();
}


$("body").on("click", "#verify_classroom", get_classroom_details);
$("body").on("click", "#classroom_enrol", enrol);
$("body").on("click", "#drop_enrolment", drop_enrolment);
$("body").on("click", "#signin", signin);
$("body").on("click", "#signout", signout);
$("body").on("click","#capture_pic_stream",verify_face)
