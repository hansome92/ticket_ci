<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?=(isset($event['EventName']) ? $event['EventName'] : 'Tibbaa - Ticketbox')?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?=$base?>images/favicon.ico"/>
    <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">

    <link href="<?=$base?>css/bootstrap.css" rel="stylesheet">
    <link href="<?=$base?>css/ticketbox/styles.css" rel="stylesheet">
    <link href="<?=$base?>css/ticketbox/menu.css" rel="stylesheet">
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

    <script type="text/javascript">var base_url = '<?=$base?>'; 
        var colors = new Array();
        <? if(!empty($event['customisationpreferences'])): 
        	$i=0; foreach($event['customisationpreferences'] as $key =>$preference): ?>
            colors[<?=$i?>] = new Array();
            colors[<?=$i?>][0] = '<?=$key?>';
            colors[<?=$i?>][1] = '<?=$preference["Value"]?>';
            <? if($key === 'background-top-color' || $key === 'background-bottom-color'): ?>
                var <?=str_replace('-', '', $key)?> = '<?=$preference['Value']?>';
            <? endif; ?>
        <? $i++; endforeach; endif; ?>
    </script>
    <script src="<?=$base?>js/dashboard/select.js"></script>

    <script src="<?=$base?>js/ticketbox/ticketbox-scripts.js"></script>
    <script src="<?=$base?>js/dashboard/validate.js"></script>


    <script>
        $( document ).ready(function() {
            $('select').fancySelect();
        });
    </script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.js"></script>
    <![endif]-->
</head>

<body>
    <div id="wrapper">
        <div class="container" id="content">
            <div class="row nopadding header">
                <div class="col-md-12 nopadding">
                    <div class="header-image">
						<? if( isset($event['customisationpreferences']['header_photo']['Value']) && $event['customisationpreferences']['header_photo']['Value'] != '' ): ?>
							<img src='<?=$base?>uploads/cover_photos/_src/<?=$event['customisationpreferences']['header_photo']['Value']?>' alt="" id="header_pic" />
						<? elseif(file_exists('./uploads/cover_photos/_src/'.$event['EventID'].'.jpg') == true): ?>
							<img src='<?=$base?>uploads/cover_photos/_src/<?=$event['EventID']?>.jpg' alt="" id="header_pic" />
						<? endif; ?>
                    </div>
                </div>
            </div>
            <? if(isset($step) && $step != 'complete'):?>
                <div class="hidden-xs row event-background-color-background" id="steps-row">
                    <div class="col-md-12">
                        <div class="steps-wrapper">
                            <div class="step <?=($step == 1 ? 'active' : '')?>">
                                <div class="step-number <?=($step == 1 ? 'primary-color-background primary-text-color-text ' : 'steps-color-background text-color-text')?>">1</div>
                                <div class="step-title <?=($step == 1 ? 'primary-text-color-text' : 'text-color-text')?>">Tickets</div>
                            </div>
                            <div class="step <?=($step == 2 ? 'active' : '')?>">
                                <div class="step-number <?=($step == 2 ? 'primary-color-background primary-text-color-text ' : 'steps-color-background text-color-text')?>">2</div>
                                <div class="step-title <?=($step == 2 ? 'primary-text-color-text' : 'text-color-text')?>">Personal info</div>
                            </div>

                            <div class="step <?=($step == 3 ? 'active' : '')?>">
                                <div class="step-number <?=($step == 3 ? 'primary-color-background primary-text-color-text ' : 'steps-color-background text-color-text')?>">3</div>
                                <div class="step-title <?=($step == 3 ? 'primary-text-color-text' : 'text-color-text')?>">Confirmation</div>
                            </div>
                            <div class="step <?=($step == 4 ? 'active' : '')?>">
                                <div class="step-number <?=($step == 4 ? 'primary-color-background primary-text-color-text ' : 'steps-color-background text-color-text')?>">4</div>
                                <div class="step-title <?=($step == 4 ? 'primary-text-color-text' : 'text-color-text')?>">Payment</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="visible-xs row event-background-color-background" id="steps-row">
                    <div class="steps-wrapper">
                        <div class="col-xs-12 step-xs">
                            <div class="step <?=($step == 1 ? 'active' : '')?>">
                                <div class="step-number <?=($step == 1 ? 'primary-color-background primary-text-color-text ' : 'steps-color-background text-color-text')?>">1</div>
                                <div class="step-title <?=($step == 1 ? 'primary-text-color-text' : 'text-color-text')?>">Tickets</div>
                            </div>
                        </div>
                        <div class="col-xs-12 step-xs">
                            <div class="step <?=($step == 2 ? 'active' : '')?>">
                                <div class="step-number <?=($step == 2 ? 'primary-color-background primary-text-color-text ' : 'steps-color-background text-color-text')?>">2</div>
                                <div class="step-title <?=($step == 2 ? 'primary-text-color-text' : 'text-color-text')?>">Personal info</div>
                            </div>
                        </div>
                        <div class="col-xs-12 step-xs">
                            <div class="step <?=($step == 3 ? 'active' : '')?>">
                                <div class="step-number <?=($step == 3 ? 'primary-color-background primary-text-color-text ' : 'steps-color-background text-color-text')?>">3</div>
                                <div class="step-title <?=($step == 3 ? 'primary-text-color-text' : 'text-color-text')?>">Confirmation</div>
                            </div>
                        </div>
                        <div class="col-xs-12 step-xs">
                            <div class="step <?=($step == 4 ? 'active' : '')?>">
                                <div class="step-number <?=($step == 4 ? 'primary-color-background primary-text-color-text ' : 'steps-color-background text-color-text')?>">4</div>
                                <div class="step-title <?=($step == 4 ? 'primary-text-color-text' : 'text-color-text')?>">Payment</div>
                            </div>
                        </div>
                    </div>
                </div>

            <? endif; ?>
            <div class="row event-background-color-background">
                <div class="col-sm-12 visible-sm visible-xs">
                    <div class="info-wrapper">
                        <p class="text-color-text"><?=$event['preferences']['description']['Value']?></p>
     
                        <table>
                            <tbody>
                                <tr>
                                    <th class="text-color-text">Event:</th>
                                    <td class="subtext-color-text"><?=$event['EventName']?></td>
                                </tr>
                                <tr>
                                    <th class="text-color-text">Date:</th>
                                    <td class="subtext-color-text"><?=(isset($event['preferences']['start_date']['Value']) ? $event['preferences']['start_date']['Value'] : $event['preferences']['starte_date']['Value'] )?></td>
                                </tr>
                                <tr>
                                    <th class="text-color-text">Venue:</th>
                                    <td class="subtext-color-text"><?=(isset($event['preferences']['venue']['Value']) && $event['preferences']['venue']['Value'] != '' ? $event['preferences']['venue']['Value'].', ' : '').$event['preferences']['city']['Value']?></td>
                                </tr>
                                <tr>
                                    <th class="text-color-text">Time:</th>
                                    <td class="subtext-color-text"><?=(isset($event['preferences']['start_time']['Value']) && $event['preferences']['start_time']['Value'] != '' ? $event['preferences']['start_time']['Value'] : '')?> - <?=(isset($event['preferences']['end_time']['Value']) && $event['preferences']['end_time']['Value'] != '' ? $event['preferences']['end_time']['Value'] : '')?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="visible-md visible-lg col-md-12">
                    <div class="info-wrapper">
                        <p class="text-color-text"><?=$event['preferences']['description']['Value']?></p>
                        
                        <table>
                            <tbody>
                                <tr>
                                    <th class="text-color-text">Event:</th>
                                    <td class="subtext-color-text"><?=$event['EventName']?></td>
                                    <th class="text-color-text">Date:</th>
                                    <td class="subtext-color-text"><?=(isset($event['preferences']['start_date']['Value']) ? $event['preferences']['start_date']['Value'] : $event['preferences']['starte_date']['Value'] )?></td>
                                </tr>
                                <tr>
                                    <th class="text-color-text">Venue:</th>
                                    <td class="subtext-color-text"><?=(isset($event['preferences']['venue']['Value']) && $event['preferences']['venue']['Value'] != '' ? $event['preferences']['venue']['Value'].', ' : '').$event['preferences']['city']['Value']?></td>
                                    <th class="text-color-text">Time:</th>
                                    <td class="subtext-color-text"><?=(isset($event['preferences']['start_time']['Value']) && $event['preferences']['start_time']['Value'] != '' ? $event['preferences']['start_time']['Value'] : '')?> - <?=(isset($event['preferences']['end_time']['Value']) && $event['preferences']['end_time']['Value'] != '' ? $event['preferences']['end_time']['Value'] : '')?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="ticketbox">

