    
    <script src="js/jquery.js"></script>
    
    <script src="js/bootstrap.min.js"></script>

    <script type="text/javascript" src="js/headroom.js"></script>
    <script type="text/javascript">	//headroom.js initialization
        jQuery( document ).ready(function(){
            var header = document.querySelector("#navbar");
            var headroom = new Headroom(header, {
                offset : 205,
                tolerance: {
                  down : 10,
                  up : 20
                },
                classes: {
                  initial: "animated",
                  pinned: "slideDown",
                  unpinned: "slideUp"
                }
            });
            headroom.init();
        });
    </script>


          
<footer class="footer-distributed" id="contact">

			<div class="footer-left">

				<h3>Teachi<span>Pedia</span></h3>

				<p class="footer-links">
					<a href="/project">Home</a>
					·
					<a href="/project/about.html">About</a>
					·
					<a href="/project/faq.html">Faq</a>
					·
					<a href="/project/contact.html">Contact</a>
				</p>

				<p class="footer-company-name">Teachipedia &copy; 2016</p>
			</div>

			<div class="footer-center">

				<div>
					<i class="fa fa-map-marker"></i>
					<p><span>University of Colorado Boulder</span> Colorado, USA</p>
				</div>

				<div>
					<i class="fa fa-phone"></i>
					<p>+1 (720)-123-4564</p>
				</div>

				<div>
					<i class="fa fa-envelope"></i>
					<p><a href="mailto:support@teachipedia.com">support@teachipedia.com</a></p>
				</div>

			</div>

			<div class="footer-right">

			

				<div class="footer-icons">

					<a href="https://www.facebook.com" target=_blank><i class="fa fa-facebook"></i></a>
					<a href="https://www.twitter.com" target=_blank><i class="fa fa-twitter"></i></a>
					<a href="https://www.linkedin.com" target=_blank><i class="fa fa-linkedin"></i></a>
					<a href="https://www.github.com" target=_blank><i class="fa fa-github"></i></a>

				</div>

			</div>

		</footer>




   



</body>

</html>

