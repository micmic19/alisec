<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
					</div>
					<?if (!$isCatalogPage):?>
					<div class="sidebar col-md-3 col-sm-4">
						<?$APPLICATION->IncludeComponent(
							"bitrix:main.include",
							"",
							Array(
								"AREA_FILE_SHOW" => "sect",
								"AREA_FILE_SUFFIX" => "sidebar",
								"AREA_FILE_RECURSIVE" => "Y",
								"EDIT_MODE" => "html",
							),
							false,
							Array('HIDE_ICONS' => 'Y')
						);//rur?>
					</div><!--// sidebar -->
					<?endif?>
				</div><!--//row-->
			</div><!--//container bx-content-seection-->
		</div><!--//workarea-->

		<footer class="bx-footer">
			<div class="bx-footer-bottomline">
				<div class="bx-footer-section container">
					<div class="col-sm-6 bx-up"><a href="javascript:void(0)" data-role="eshopUpButton"><i class="fa fa-caret-up"></i> <?=GetMessage("FOOTER_UP_BUTTON")?></a></div>
				</div>
			</div>


		</footer>
	</div> <!-- //bx-wrapper -->

<script>
	BX.ready(function(){
		var upButton = document.querySelector('[data-role="eshopUpButton"]');
		BX.bind(upButton, "click", function(){
			var windowScroll = BX.GetWindowScrollPos();
			(new BX.easing({
				duration : 500,
				start : { scroll : windowScroll.scrollTop },
				finish : { scroll : 0 },
				transition : BX.easing.makeEaseOut(BX.easing.transitions.quart),
				step : function(state){
					window.scrollTo(0, state.scroll);
				},
				complete: function() {
				}
			})).animate();
		})
	});
</script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter4952986 = new Ya.Metrika({id:4952986,
                    webvisor:true,
                    clickmap:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/4952986" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<!-- /Google.Analytics counter-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-49310212-1', 'alice.ru');
  ga('send', 'pageview');
</script>
<!-- /Google.Analytics counter-->
<?
//#ALICE
Global $APPLICATION;
$APPLICATION->SetPageProperty("description","B2B");
$APPLICATION->SetPageProperty("title","B2B");
//#ALICE
?>
</body>
</html>
