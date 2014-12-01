<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tibbaa Dashboard</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?=$base?>images/favicon.ico"/>

    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <link href="<?=$base?>css/dashboard/stylesheet.less" rel="stylesheet">

    <script type="text/javascript">
    var data = [
        <? if(isset($statistics['dailystats']) && !empty($statistics['dailystats'])):?>
            <? foreach (array_reverse($statistics['dailystats']) as $key => $value) : ?>
                ['<?=$value[0]?>', <?=$value[1]?>],
            <? endforeach; ?>
        <? endif; ?>
    ];
    var base_url = '<?=$base?>';
    <? if( isset($event['EventID']) ):?>
        var event_id = '<?=$event['EventID']?>';
    <? endif; ?>
    </script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

    <script src="<?=$base?>js/dashboard/less.js"></script>
    <script src="<?=$base?>js/dashboard/barchart.js"></script>
    <script src="<?=$base?>js/dashboard/tooltip.js"></script>
    <script src="<?=$base?>js/dashboard/select.js"></script>
    <script src="<?=$base?>js/dashboard/jquery.bxslider.js"></script>
    <script type="text/javascript" src="<?=$base?>js/dashboard/bootstrap-timepicker.js"></script>
    <script src="<?=$base?>js/dashboard/tagsinput.min.js"></script>

    <script src="<?=$base?>js/dashboard/custom.js"></script>
    <script src="<?=$base?>js/dashboard/dashboard-scripts.js"></script>
    <script src="<?=$base?>js/dashboard/validate.js"></script>
    <script src="<?=$base?>js/frontend/jquery.fancybox.js"></script>
    <script src="<?=$base?>js/dashboard/jquery.number.min.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="<?=$base?>js/dashboard/html5shiv.js"></script>
        <script src="<?=$base?>js/dashboard/respond.js"></script>
        <![endif]-->
        <script type="text/javascript">
        $( document ).ready(function() {
            $('.forced-popup').fancybox({
                'closeBtn' : false, 
                'closeClick' : false,
                //'onComplete' : function(){$('.fb_event#disagree').click(function(){parent.$.fancybox.close();})}, 
                'helpers' : {
                    'overlay' : {
                        'closeClick' : false
                    }

                }
            });
            $('.popup-help').click(function(e){
                e.preventDefault();
                $.post( "<?=$base?>dashboardajax/getpopupcontent", {popupid: $(this).attr("data-id"), type: $(this).attr("data-type")})
                  .done(function( data ) {
                      data = eval('(' + data + ')')
                      $("#help-title").html( data['Descript'] );
                      $("#help-content").html( '<p>'+data['HelpContent']+'</p>' );
                  });
            });
            $('.popup-help').fancybox();
            <? $popup = _getPopup( (isset($pageId) ? $pageId : '')); if( !empty($popup) ): ?>
                $('.forced-popup').click();
            <? endif; ?>
        }, 'json');
        </script>
    </head>
    <body>
        <? if( !empty($popup) ): ?>
            <a href="#popup" class="forced-popup"></a>
            <div id="popup" style="display:none;">
                <div class="lightbox-content hidden-xs">
                        <div class="lightbox-head">
                            <img src="<?=$base?>images/frontend/lightbox-logo.png">
                        </div>
                        <div class="lightbox-mid">
                            <div class="stripes">
                                <span class="lightbox-title"><?=( isset($popup['preferences']['title']['Value']) ? $popup['preferences']['title']['Value'] : 'Sorry, but we need something from you.')?></span>
                            </div>
                            <div class="clear"></div>
                            <span class="popup-content"><? if( !empty($popup) ): ?><?=$popup['preferences']['content']['Value']?><? endif; ?></span>
                            
                            <? if( $popup['Type'] == '2' ): ?>
                                <iframe width="560" height="315" src="<?=$popup['preferences']['video']['Value']?>" frameborder="0" allowfullscreen></iframe>
                            <? endif; ?>

                            <? if( $popup['Type'] == '1' ): ?>
                                <a class="disagree agreement" id="disagree" href="#">I disagree</a>
                                <a class="agree agreement" id="agree" href="#">I agree</a>
                            <? elseif( $popup['Type'] == '2' ): ?>
                                <a class="agree agreement" id="agree" href="#">I get it</a>
                            <? elseif( $popup['Type'] == '3' ): ?>
                                <form action="<?=$base?>sponsors/newevent" method="post" id="post-facebook-event-form">
                                    <div class="form-wrapper">
                                        <label id="facebook_event_label" for="facebook_event">https://www.facebook.com/events/</label>
                                        <input type="text" name="facebook_event" id="facebook_event" value="" placeholder="event id">
                                        <p class="error" id="facebook-event-error"></p>
                                    </div>
                                    <input type="submit" value="Okay" style="display:none;" />
                                </form>
                                <a class="disagree fb_event" id="disagree" href="#">No thanks</a>
                                <a class="agree fb_event" id="agree" href="#">Go!</a>
                            <? endif; ?>
                            <input type="hidden" value="<?=$popup['ID']?>" id="popup-id" />
                        </div>
                </div>
            </div>
        <? endif; ?>
        <div id="popup-help" style="display:none;">
            <div class="lightbox-content hidden-xs">
                <form id="loginform" method="post" action="">
                    <div class="lightbox-head">
                        <img src="<?=$base?>images/frontend/lightbox-logo.png">
                    </div>
                    <div class="lightbox-mid">
                        <div class="stripes">
                            <span class="lightbox-title" id="help-title"></span>
                        </div>
                        <div class="clear"></div>
                        <span class="popup-content" id="help-content"></span>
                        
                    </div>
                </form>
            </div>
        </div>

        <div id="side-nav" class="visible-xs">
          <a href="">
            <img src="<?=$base?>images/dashboard/logo.png" id="logo" />
        </a>
        <span id="menu-start">MENU</span>

        <ul class="clearfix " id="menu">
            <li><a href="<?=$base?>dashboard" class="<? if(!isset($active_menu)):?>active<? endif; ?> icon-grid"><i></i>Dashboard</a></li>
            <li><a href="#" class="<? if(isset($active_menu) && $active_menu == 'events'):?>active<? endif; ?> icon-events"><i></i>Campaign</a></li>
        <!--<li><a href="#" class="icon-reports"><i></i>Reports</a></li>
        <li><a href="#" class="icon-stats"><i></i>Statistics</a></li>
        <li><a href="#" class="icon-inbox"><i></i>Messages <span class="dark pill">22</span></a></li>-->
    </ul>
</div>

<div id="top" class="hidden-xs">
  <a href=""><img src="<?=$base?>images/dashboard/logo.png" id="logo" /></a>
  <a href="<?=$base?>dashboard/newcampaign" class="button icon icon-plus hidden-xs">Create campaign</a>
  <span id="menu-start" class="hidden-xs" >MENU</span>
  <ul class="clearfix " id="menu">
    <li><a href="<?=$base?>dashboard" class="<? if(!isset($active_menu)):?>active<? endif; ?> icon-grid"><i></i>Dashboard</a></li>
    <li><a href="<?=$base?>dashboard/events" class="<? if(isset($active_menu) && $active_menu == 'events'):?>active<? endif; ?> icon-events"><i></i>Campaigns</a></li>
        <!--<li><a href="#" class="icon-reports"><i></i>Reports</a></li>
        <li><a href="#" class="icon-stats"><i></i>Statistics</a></li>
        <li><a href="#" class="icon-inbox"><i></i>Messages <span class="dark pill">22</span></a></li>-->
    </ul>
</div>
<div id="mobile-top" style="visible-xs">
  <a class="side-pull"></a>
</div>

<div id="wrapper">

    <div id="topbar" class="hidden-xs">
      <div id="top-search">
        <form>
          <input type="text" placeholder="Search..." />
      </form>
  </div>
  <div id="options">
    <a href="<?=$base?>dashboard/profile" class="account">Profile</a>
    <a href="<?=$base?>dashboard/settings" class="settings">Settings</a>
    <a href="<?=$base?>logout" class="help">Logout</a>
</div>
</div>