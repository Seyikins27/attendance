function countdown(elementName, minutes, seconds) {
    var element, endTime, hours, mins, msLeft, time;

    function twoDigits(n) {
        return n <= 9 ? "0" + n : n;
    }

    function updateTimer() {
        msLeft = endTime - +new Date();
        if (msLeft < 1000) {
            document.getElementById("activity_form").submit();
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


function preview(ev)
{
    let base_url = $('meta[name="site_url"]').attr("content");
    let preview_id=$(this).attr('data-value');
    let preview=$("#preview_"+preview_id);
    ev.preventDefault();
}

