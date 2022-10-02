<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="site_url" content="{{url("")}}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{"Attendance Box "}} - Register</title>

    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    {{-- <link rel="stylesheet" href="{!! asset('css/bootstrap.min.css') !!}" /> --}}
    <link rel="stylesheet" href="{!! asset('css/vendor.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}" />
    <link rel="stylesheet" href="{!! asset('font-awesome/css/font-awesome.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/modal-css.css') !!}" />
</head>
<body class="gray-bg">
<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        @include('layouts.error')
        <div>
            <h3>Welcome to Attendance Box</h3>
            <h1 class="logo-name"><i class="fa fa-clock-o"></i></h1>
        </div>
        <p> <strong>Create an account as a student.</strong> </p>
        <form class="m-t" role="form" action="{{route('student-add')}}" method="POST">
            @csrf

                <div class="form-group">
                    <input type="text" name="idno" class="form-control" placeholder="Enter Your Student ID Number" required="">
                </div>

                <div class="form-group">
                    <input type="text" name="firstname" class="form-control" placeholder="Firstname" required="">
                </div>

                <div class="form-group">
                    <input type="text" name="middlename" class="form-control" placeholder="Middlename" required="">
                </div>

                <div class="form-group">
                    <input type="text" name="lastname" class="form-control" placeholder="Lastname" required="">
                </div>

                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required="">
                </div>

                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="">
                </div>

                <div class="form-group">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required="">
                </div>

                <hr>
                Register your face
                <hr>
                <div class="contentarea">
                    <p>
                       Click the Take Photo Button to Capture Your Picture
                    </p>
                    <div class="camera">
                      <video id="video">Video stream not available.</video>
                      <button id="startbutton" class="btn btn-sm btn-info">Take photo</button>
                    </div>
                    <canvas id="canvas">
                    </canvas>
                    <div class="output" style="display:none">
                      <img id="photo" alt="The screen capture will appear in this box.">
                    </div>
                    <input type="hidden" name="captured_pic" id="captured_pic">
                  </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Register</button>

                <p class="text-muted text-center"><small>Already have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="{{route('student-login')}}">Login</a>
            </form>
        <p class="m-t"> <small>Attendance Box &copy; {{date('Y')}}</small> </p>
    </div>
</div>
<script>
     (() => {
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
  let captured_pic=null
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
    captured_pic=document.getElementById('captured_pic');
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
      takepicture();
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
      captured_pic.setAttribute('value',data);
    } else {
      clearphoto();
    }
  }

  // Set up our event listener to run the startup process
  // once loading is complete.
  window.addEventListener('load', startup, false);
})();

</script>
</body>
</html>

