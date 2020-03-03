<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '1739467189694705');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=1739467189694705&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

<div id='maindiv' style='top:0px; left: 0px; position: fixed;
min-width: 600px;
    width: 100%;
    z-index: 99999;
    font-family: Helvetica Neue, Sans-serif;
    -webkit-font-smoothing: antialiased;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
    -webkit-transition: all 0.25s ease;
    transition: all 00.25s ease; background-color:rgba(255, 255, 255, 0.85);
    display: block;' >
    <div class="content" style=' width: 100%;
    overflow: hidden;
    height: 76px;
    color: #333;
    margin-right: 4px;
    position: relative;
    line-height: 1.2em;' >
        <div style='float: right;     float: right;
    height: 63px;
    margin-bottom: 50px;
    padding-top: 22px;
    z-index: 1;
    margin-right: 4px;
    position: relative;
    line-height: 1.2em;' >
            <form id="sms-form">
                <input type="phone" name="phonenumber" id="phonenumber" placeholder="Enter your 10 digit number" style="width: 200px;     border: 1px solid #ccc;
    font-weight: 400;
    border-radius: 4px;
    height: 30px;
    padding: 5px 7px 4px;
    font-size: 14px;
    vertical-align: bottom;
    font-size: 15px;">
                <button type="button" style='    border: 1px solid #ccc;
    background: #fff;
    color: #000;
    cursor: pointer;
    margin-top: 0px;
    font-size: 14px;
    display: inline-block;
    margin-left: 5px;
    font-weight: 400;
    text-decoration: none;
    border-radius: 4px;
    padding: 6px 12px;
    transition: all .2s ease;
    vertical-align: bottom;
    font-size: 15px;
    margin-right: 4px;
    position: relative;
    line-height: 1.2em;' onclick='sendsmss();'>Send Link</button>
            </form>
        </div>
        <div style='float: left;float: left;width: 50%;' >
         <!--   <div id="closethis" style='color: #000;
    font-size: 24px;
    top: 14px;
    opacity: .5;
    transition: opacity .3s ease;
    font-weight: 400;
    cursor: pointer;
    float: left;
    z-index: 2;
    padding: 0 5px 0 5px;
    margin-right: 0;
    margin-right: 4px;
    position: relative;
    line-height: 1.2em;' onclick='closethisdiv();'>×</div>    -->
            <div class="icon" style='float: left;
    padding-bottom: 40px;
    margin: 10px;
    margin-top: 5px;
    position: relative;
    line-height: 1.2em;'><img src="http://api001.mguru.co.in/images/logo.png" style='    width: 63px;
    height: 63px;
    margin-right: 0;
    margin-right: 4px;
    line-height: 1.2em;'></div>
            <div class="details" style='
    margin-right: 4px;
    margin-top: 20px;
    position: relative;
    line-height: 1.2em;'>
            <div class="title" style='display: block;
    font-size: 18px;
    font-weight: bold;
    color: #555;
    margin-right: 4px;
    position: relative;
    line-height: 1.2em;'>mGuru</div>
            <div class="description" style='display: block;
    font-size: 12px;
    font-weight: normal;
    color: #777;
    max-height: 30px;
    overflow: hidden;
    margin-right: 4px;
    position: relative;
    line-height: 1.2em;
'>Fast and interactive way for children to learn English & Maths.</div>
            </div>
        </div>
    </div>
</div>

<script>
function closethisdiv() {
    document.getElementById('maindiv').style.display = "none";
}

function sendsmss() {
    var numm =  document.getElementById('phonenumber').value;

    if (/^\d{10}$/.test(numm)) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

            }
        };
        xhttp.open("GET", "http://api001.mguru.co.in/site/sendsms1?numm=" + numm, true);
        xhttp.send();

        fbq('track', 'ViewContent', {
    value: 100,
    currency: 'INR',
    content_type: 'Send Download App Link to Mobile',
  });

        document.getElementById("sms-form").innerHTML = "Download link sent to your mobile!";
    } else {
        alert("Invalid mobile number; must be ten digits")
        numm.focus()
        return false
    }
}
</script>

<style>
@media screen and (max-width: 600px) {
  #maindiv {
    visibility: hidden;
    clear: both;
    display: none;
  }
}
</style>