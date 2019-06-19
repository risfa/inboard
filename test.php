<style media="screen">

  body{
      margin: 0px;
  }

  #leftdiv{
      background-color: #A9F5D0;
      float: left;
      height:100%;
      width: 30%;

  }

  #rightdiv{
      background-color: #F8E0F1;
      float: left;
      height: 100%;
      width: 70%;
  }

  #lectname{
      padding:10px;
      font-family: "comic sans ms";
  }
</style>

<div id="container">

    <div id="leftdiv">

        <div id="lectname">
            <p><a class="video" href="M0mx8S05v60">Lec 01: What is Signal?</a></p>
            <p><a class="video" href="F5h3z8p9dPg">Lec 02: What is an Analog Signal?</a></p>
            <p><a class="video" href="jRL9ag3riJY">Lec 03: What is Digital Signal?</a></p>
            <p><a class="video" href="izBaDRyqnBk">Lec 04: Need of Digital Signal</a></p>
            <p><a class="video" href="2xXErGeeb_Q">Lec 05: Introduction to Digital Electronics</a></p>
            <p><a class="video" href="RF9I6UzI4Rc">Lec 06: Switch and Bits Intuition</a></p>
        </div>

        <button onclick="myFunction()" id="button_test" value="M0mx8S05v60"   name="button">test</button>

    </div>

    <div id="rightdiv">
        <iframe id="videoFrame" width="480" height="270" frameborder="0" allowfullscreen></iframe>
    </div>

</div>

<script type="text/javascript">



// when a video link is clicked, change the URL
var onVideoLinkClick = function(e){

// did we click on a link with class "video"?
if( e.target.tagName == 'A' && e.target.classList.contains('video')){

  var videoID = e.target.getAttribute('href');

  // change the url
  history.pushState(
    {videoID: videoID},	// data
    e.target.innerText,	// title
    ''		// url path
  )

  // then change the video
  changeVideo(videoID)

  // stop the default link action
  e.preventDefault();
}

}

function myFunction(){
var alert123 =  document.getElementById('button_test').value;

// change the url
history.pushState(
  {alert123: alert123},	// data
  alert123.innerText,	// title
  ''		// url path
)
// then change the video
changeVideo(alert123)
}

// change the playing video to a new video ID
var changeVideo = function(videoID){
var src = 'https://www.youtube.com/embed/'+videoID;
document.getElementById("videoFrame").src = src;
}

// triggered when clicking on a video using the back/forward browser button
var onUrlChange = function(e){
changeVideo(e.state.videoID)
}

// bind the event listners
window.addEventListener('click', onVideoLinkClick);
window.onpopstate = onUrlChange;

</script>
