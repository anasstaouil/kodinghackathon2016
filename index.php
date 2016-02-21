<!doctype html> 
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TASK.</title>
    <link rel="stylesheet" href="/pure-min.css">
    <link rel="stylesheet" href="/rating.css">
    <script src="zepto.min.js"></script>
    <script type="text/javascript">
      function processajaxdata(data) {      
        switch(data.action) {
          case "updatedata":
            $("#projectname").text(data.data.project.projectname);
            $("#projectwhitetasks").text(data.data.project.all);
            $("#projectgreentasks").text(data.data.project.done);
            $("#projectredtasks").text(data.data.project.red);
            $("#freezecount").text(data.data.project.freezed);
            $("#currenttaskdisplay").attr("class", data.data.task.state);
            $("#taskdifficulty").parent().attr("class", "difficulty difficulty-"+data.data.task.difficulty);
            $("#taskname").text(data.data.task.taskname);
            $("#tasknamespan").attr("data-more", data.data.task.description);
            $("#taskdependscount").text(data.data.task.dependentscount);
            $("#passed").text(data.data.task.passed);
            
            if (data.data.task.notask) {
              $("#passtask").addClass("pure-button-disabled");
              $("#donetask").addClass("pure-button-disabled");
            }
            else {
              $("#passtask").removeClass("pure-button-disabled");
              $("#donetask").removeClass("pure-button-disabled");
            }
          break;
          case "changepage":
          break;
          case "erroraddtask":
          break;
        }
      }
      function updatedata(){
        $.ajax({
          type: 'POST',
          url: '/ajax.php',
          data: JSON.stringify({action: 'updatedata'}),
          dataType: 'json',
          contentType: 'application/json',
          timeout: 3000,
          context: $('body'),
          success: function(data){
            processajaxdata(data);
          },
          error: function(xhr, type){
            alert('Ajax error!')
          }
        });
      }
    </script>
    <style>
      mark {
        border-radius: 2px;
        display: inline-block;
        line-height: 1;
        padding: 0.1rem 0.4rem;
        background-color: #ffd61e;
        color: #202020;
        text-decoration: none;
      }
      .badge {
        border-radius: 30px;
        min-width: 17px;
        color: #000;
        display: inline;
        font-size: 11px;
        font-weight: normal;
        line-height: 1;
        padding: 0.2rem 0.7rem;
        position: relative;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
      }
      .badge.badge-white {
        background: #ffffff none repeat scroll 0 0;
        color: #000000;
      }
      .badge.badge-red {
        background: #ff0000 none repeat scroll 0 0;
        color: #ffffff;
      }
      .badge.badge-green {
        background: #0a8754 none repeat scroll 0 0;
        color: #ffffff;
      }
      #layout {
        width: 600px;
        height: 500px;
        position: absolute;
        top:0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        border: solid 1px black;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;         
      }
      .top {
        width: 600px;
        height: 150px;
        
        text-align: center;
        color: #fff;
        background: rgb(61, 79, 93) none repeat scroll 0 0;
      }
      .middle {
        width: 600px;
        height: 250px;
      }
      .bottom {
        width: 600px;
        height: 100px;
      }
      .prj-title {
        text-transform: uppercase;
      }
      .prj-title, .prj-stats {
        margin: 0;
      }
      .nav-list {
        list-style: outside none none;
        margin: 0;
        padding: 0;
      }
      .nav-item {
        display: inline-block;
      }
      .nav-item a {
        background: transparent none repeat scroll 0 0;
        border: 2px solid rgb(176, 202, 219);
        color: #fff;
        font-size: 85%;
        letter-spacing: 0.05em;
        margin-top: 1em;
        text-transform: uppercase;
      }
      
      #currenttaskdisplay {
        height: 250px;
        margin-top:0;
        margin-bottom: 0;
        margin-left: 0;
        margin-right: 0;
      }
      
      #currenttaskdisplay.grey {
        background: grey none repeat scroll 0 0;
      }
      
      #currenttaskdisplay.red {
        background: red none repeat scroll 0 0;
      }
      
      #currenttaskdisplay.green {
        background: green none repeat scroll 0 0;
      }
      
      .button-success {
        background: rgb(28, 184, 65);
      }

      .button-warning {
        background: rgb(223, 117, 20);
      }
      
      #newtask {
        text-align: center;
      }
      
      #details {
        text-align: center;
      }
      
      .tooltip{
        display: inline;
        position: relative;
      }
      

      .tooltip:hover:after{
        background: #333;
        background: rgba(0,0,0,.8);
        border-radius: 5px;
        top: 56px;
        color: #fff;
        content: attr(data-more);
        left: 20%;
        padding: 5px 15px;
        position: absolute;
        z-index: 98;
        width: 300px;
        font-size = 1em !important;
      }
      
      /*.tooltip:hover:before{
        border: solid;
        border-color: #333 transparent;
        border-width: 6px 6px 0 6px;
        top: 50px;
        content: "";
        left: 50%;
        position: absolute;
        z-index: 99;
      }*/
      
      .difficulty-0:after {
        content: ' ';
      }
      
      .difficulty-1:after {
        content: '★ ';
      }
      
      .difficulty-2:after {
        content: '★ ★ ';
      }
      
      .difficulty-3:after {
        content: '★ ★ ★ ';
      }
      
      .difficulty-4:after {
        content: '★ ★ ★ ★ ';
      }
      
      .difficulty-5:after {
        content: '★ ★ ★ ★ ★ ';
      }
      
      .difficulty {
        color: black;
        font-size: 2em;
        z-index: 99;
      }
      
      .rating {
        display: inline-block;
        width: 100%;
        padding-left: auto;
        padding-right: auto;
      }
    </style>
  </head>
  <body>
    <div id="layout" class="pure-g">
    <div id="project" class="top pure-u-1">
      <div class="header">
        <h1 class="prj-title" id="projectname"></h1>
        <h2 class="prj-stats">
          <span id="projectwhitetasks" class="badge badge-white"></span>
          <span id="projectgreentasks" class="badge badge-green"></span>
          <span id="projectredtasks" class="badge badge-red"></span>
        </h2>

        <nav class="nav">
          <ul class="nav-list">
            <li class="nav-item">
              <a class="pure-button" href="javascript:void(0);" id="addnewtask">Add task</a>
            </li>
            <li class="nav-item hidden">
              <a class="pure-button" href="javascript:void(0);" id="freezedtasks">Freezed tasks<mark id="freezecount"></mark></a>
            </li>
            <li class="nav-item">
              <a class="pure-button" href="javascript:void(0);" id="tasksstats">Stats</a>
            </li>
            <li class="nav-item">
              <a class="pure-button" href="javascript:void(0);" id="changeproject">Projects</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>  
    <div id="newtask" class="middle pure-form hidden pure-u-1">
      <fieldset class="pure-group">
        <input type="text" class="pure-input-1" placeholder="A title" name="name">
        <textarea class="pure-input-1" placeholder="A description" name="description"></textarea>
        <fieldset class="rating pure-group">
          <legend class=" pure-u-1 ">Difficulty:</legend>
            <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="Impossible!">5 stars</label>
            <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="Very hard">4 stars</label>
            <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="Kinda hard">3 stars</label>
            <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="Easy">2 stars</label>
            <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="Very easy">1 star</label>
        </fieldset>
      </fieldset>
    </div>
    <div id="selectproject" class="middle hidden pure-u-1"></div>
    <div  id="currenttask" class="middle pure-u-1">
      <div id="currenttaskdisplay" class="">
        <div id="details" class="pure-u-1">
          <span data-more="" class="pure-u-1 tooltip" id="tasknamespan"><h1 id="taskname"></h1></span>
          <span class="pure-u-1"><span id="taskdifficulty" class=""> </span></span>
          <span id="taskdependscount" class="pure-u-1-2 hidden"></span>
          <span id="passed" class="pure-u-1-2 hidden"></span>
        </div>
        <div id="currenttaskactions">
          <span id="freeze" class="hidden"></span>
          <span id="doubletime" class="hidden"></span>
          <span id="halvetime" class="hidden"></span>
        </div>
      </div>
    </div>
    <div id="navcontrols" class="bottom pure-u-1">
      <button id="passtask" class="button-warning pure-button pure-u-1">Pass</button>
      <button id="donetask" class="button-success pure-button pure-u-1">Done</button>
      <span id="break" class="hidden">Take a break</span>
      <span id="endwork" class="hidden">End work</span>
    </div>
    <div id="addtaskcontrols" class="bottom pure-u-1 hidden">
      <button id="submittask" class="button-success pure-button pure-u-1">Add task</button>
      <button id="canceladdtask" class="button-warning pure-button pure-u-1">Cancel</button>
      <span id="break" class="hidden">Take a break</span>
      <span id="endwork" class="hidden">End work</span>
    </div>
</div>
    
    <script type="text/javascript">
    $(function() {
      $("#addnewtask").on("click", function(e) {
        $("#navcontrols").addClass("hidden");
        $("#currenttask").addClass("hidden");
        $("#addtaskcontrols").removeClass("hidden");
        $("#newtask").removeClass("hidden");
      });
      $("#canceladdtask").on("click", function(e) {
        $("#navcontrols").removeClass("hidden");
        $("#currenttask").removeClass("hidden");
        $("#addtaskcontrols").addClass("hidden");
        $("#newtask").addClass("hidden");
      });
      $("#submittask").on("click", function(e) {
        if ($("input[name=name]").val()=="" || $("[name=description]").val()=="") {
          alert("Add a title and a description");
        }
        else {
          var diff = 1;
          if ($("#star1").prop("checked")) {diff = 1;}
          if ($("#star2").prop("checked")) {diff = 2;}
          if ($("#star3").prop("checked")) {diff = 3;}
          if ($("#star4").prop("checked")) {diff = 4;}
          if ($("#star5").prop("checked")) {diff = 5;}
          $.ajax({
            type: 'POST',
            url: '/ajax.php',
            data: JSON.stringify({action: 'addtask', data: {name: $("input[name=name]").val(), description: $("[name=description]").val(), difficulty: diff}}),
            dataType: 'json',
            contentType: 'application/json',
            timeout: 3000,
            context: $('body'),
            success: function(data){
              $("#navcontrols").removeClass("hidden");
              $("#currenttask").removeClass("hidden");
              $("#addtaskcontrols").addClass("hidden");
              $("#newtask").addClass("hidden");
              $("#star"+diff).prop("checked", false);
              $("input[name=name]").val("");
              $("[name=description]").val("");
              processajaxdata(data);
            },
            error: function(xhr, type){
              alert('Ajax error!')
            }
          });
        }
      });
      $("#passtask").on("click", function(e) {
        $.ajax({
          type: 'POST',
          url: '/ajax.php',
          data: JSON.stringify({action: 'passtask'}),
          dataType: 'json',
          contentType: 'application/json',
          timeout: 3000,
          context: $('body'),
          success: function(data){
            processajaxdata(data);
          },
          error: function(xhr, type){
            alert('Ajax error!')
          }
        });
      });
      $("#donetask").on("click", function(e) {
        $.ajax({
          type: 'POST',
          url: '/ajax.php',
          data: JSON.stringify({action: 'donetask'}),
          dataType: 'json',
          contentType: 'application/json',
          timeout: 3000,
          context: $('body'),
          success: function(data){
            processajaxdata(data);
          },
          error: function(xhr, type){
            alert('Ajax error!')
          }
        });
      });
      $("#changeproject").on("click", function(e) {alert("Not Yet Implemented");});
      $("#tasksstats").on("click", function(e) {alert("Not Yet Implemented");});
      setInterval(updatedata, 10000);
      updatedata();
    });
    </script>
  </body>
</html>


