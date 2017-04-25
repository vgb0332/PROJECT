<?php
require("config/config.php");
require("lib/db.php");
$conn=db_init($config["host"],$config["duser"],$config["dpw"],$config["dname"]);
?>
<!DOCTYPE HTML>
<html style="background-color:rgba(255,255,255,1);">
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>RAIZ Blog :: Write</title>
		<link href="css/style.css" rel='stylesheet' type='text/css' />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="images/fav-icon.png" />
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		</script>
		<!----webfonts---->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
		<!----//webfonts---->
		<!-- Global CSS for the page and tiles -->
  		<link rel="stylesheet" href="css/main.css">
  		<!-- //Global CSS for the page and tiles -->
		<!---start-click-drop-down-menu----->
		<script src="js/jquery.min.js"></script>

		<script>
			UPLOADCARE_LOCALE = "en";
			UPLOADCARE_TABS = "file url facebook gdrive";
			UPLOADCARE_PUBLIC_KEY = "d8942be81c58a5c7b877";
		</script>
		<script charset="utf-8" src="//ucarecdn.com/libs/widget/2.10.3/uploadcare.full.min.js"></script>
        <!----start-dropdown--->
         <script type="text/javascript">
			var $ = jQuery.noConflict();
				$(function() {
					$('#activator').click(function(){
						$('#box').animate({'top':'0px'},500);
					});
					$('#boxclose').click(function(){
					$('#box').animate({'top':'-700px'},500);
					});
				});
				$(document).ready(function(){
				//Hide (Collapse) the toggle containers on load
				$(".toggle_container").hide();
				//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
				$(".trigger").click(function(){
					$(this).toggleClass("active").next().slideToggle("slow");
						return false; //Prevent the browser jump to the link anchor
				});

			});
		</script>
        <!----//End-dropdown--->
		<!---//End-click-drop-down-menu----->
	</head>
	<body>
		<!---start-wrap---->
			<!---start-header---->
			<div class="header">
				<div class="wrap">
				<div class="logo">
					<a href="index.html"><img src="images/logo.png" title="pinbal" /></a>
				</div>
				<div class="nav-icon">
					 <a href="#" class="right_bt" id="activator"><span> </span> </a>
				</div>
				 <div class="box" id="box">
					 <div class="box_content">
						<div class="box_content_center">
						 	<div class="form_content">
								<div class="menu_box_list">
									<ul>
										<li><a href="#"><span>home</span></a></li>
										<li><a href="#"><span>About</span></a></li>
										<li><a href="#"><span>Works</span></a></li>
										<li><a href="#"><span>Clients</span></a></li>
										<li><a href="#"><span>Blog</span></a></li>
										<li><a href="contact.html"><span>Contact</span></a></li>
										<div class="clear"> </div>
									</ul>
								</div>
								<a class="boxclose" id="boxclose"> <span> </span></a>
							</div>
						</div>
					</div>
				</div>
				<div class="top-searchbar">
					<form>
						<input type="text" /><input type="submit" value="" />
					</form>
				</div>
				<div class="userinfo">
					<div class="user">
						<ul>
							<li><a href="#"><img src="images/user-pic.png" title="user-name" /><span>손님</span></a></li>
						</ul>
					</div>
				</div>
				<div class="clear"> </div>
			</div>
		</div>

    <div class="content" style="background-color:rgba(255,255,255,1);">
			<div class="wrap">
			 <div id="main" role="main">

         <article>
           <form action="process.php" method="post">

						 <select class="form-group" name="category">
						   <option>아파트/주택</option>
						   <option>토지</option>
						   <option>건물</option>
						   <option>오피스</option>
						   <option>공공데이터</option>
							 <option>기타</option>
						 </select>

	           <div class="form-group">
	             <label for="form-title">제목</label>
	             <input type="text" class="form-control" name="title" id="form-title" placeholder="제목을 입력하세요">
	           </div>

	           <div class="form-group">
	             <label for="form-author">작성자</label>
	             <input type="text" class="form-control" name="author" id="form-author" placeholder="작성자를 입력하세요">
	           </div>

						 <div class="form-group">
							 <label for="form-img">이미지url</label>
							 <input type="text" class="form-control" name="img" id="form-img" placeholder="이미지 url을 입력하세요">
						 </div>

	           <div class="form-group">
	             <label for="form-">본문</label>
	             <textarea class="form-control" rows=10 name="description" id="form-description" placeholder="본문을 입력하세요"></textarea>
	           </div>
						 <input type="hidden" role="uploadcare-uploader"
				       data-crop="disabled"
				       data-preview-step="true"
				       data-images-only="true" />
	           <input type="submit" name="name" class="btn btn-default btn-lg">
           </form>
         </article>
				 <script>

				 </script>
				 <script>
				 	var singleWidget = uploadcare.SingleWidget('[role=uploadcare-uploader]');
					singleWidget.onUploadComplete(function(info){
						document.getElementById('form-description').value = document.getElementById('form-description').value + '<img src="' + info.cdnUrl+'">';
					});
				 </script>


       </div>
   </div>
 </div>


    <!----wookmark-scripts---->
		  <script src="js/jquery.imagesloaded.js"></script>
		  <script src="js/jquery.wookmark.js"></script>
      <script src="bootstrap/js/bootstrap.min.js"></script>
		  <script type="text/javascript">
		    (function ($){
		      var $tiles = $('#tiles'),
		          $handler = $('li', $tiles),
		          $main = $('#main'),
		          $window = $(window),
		          $document = $(document),
		          options = {
		            autoResize: true, // This will auto-update the layout when the browser window is resized.
		            container: $main, // Optional, used for some extra CSS styling
		            offset: 20, // Optional, the distance between grid items
		            itemWidth:280 // Optional, the width of a grid item
		          };
		      /**
		       * Reinitializes the wookmark handler after all images have loaded
		       */
		      function applyLayout() {
		        $tiles.imagesLoaded(function() {
		          // Destroy the old handler
		          if ($handler.wookmarkInstance) {
		            $handler.wookmarkInstance.clear();
		          }

		          // Create a new layout handler.
		          $handler = $('li', $tiles);
		          $handler.wookmark(options);
		        });
		      }
		      /**
		       * When scrolled all the way to the bottom, add more tiles
		       */
		      /*function onScroll() {
		        // Check if we're within 100 pixels of the bottom edge of the broser window.
		        var winHeight = window.innerHeight ? window.innerHeight : $window.height(), // iphone fix
		            closeToBottom = ($window.scrollTop() + winHeight > $document.height() - 100);

		        if (closeToBottom) {
		          // Get the first then items from the grid, clone them, and add them to the bottom of the grid
		          var $items = $('li', $tiles),
		              $firstTen = $items.slice(0, 10);
		          $tiles.append($firstTen.clone());

		          applyLayout();
		        }
		      };*/

		      // Call the layout function for the first time
		      applyLayout();

		      // Capture scroll event.
		      //$window.bind('scroll.wookmark', onScroll);
		    })(jQuery);
		  </script>
		<!----//wookmark-scripts---->
		<!----start-footer--->
		<div class="footer">
			<p>&copy; 2017 RAIZ. All rights reserved.</p>
		</div>
		<!----//End-footer--->
		<!---//End-wrap---->
	</body>
</html>
