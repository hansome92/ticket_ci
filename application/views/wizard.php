		<!--<script>
			$(document).ready(function() {
				$('.wiz-form').validate();
				var currStep = 1;
				$("#steps li").eq(currStep-1).addClass("active")
				$("form table").not("#step"+currStep+" .ticketbox table").css({marginLeft:$(document).width() + "px"});
				
				$("#steps li a").click(function() {
					currIndex = $(this).parent().index() + 1;
					
					$("#steps li.active").removeClass("active").parent().find("li:eq("+(currIndex - 1)+")").addClass("active");
					if (currIndex > currStep) {
						$("#step"+currStep).animate({marginLeft:"-"+$(document).width()+"px"});
							currStep++;
					} else {
						$("#step"+currStep).animate({marginLeft:$(document).width()+"px"});
							currStep++;
					}
					currStep = currIndex;
				
					$("#step"+currIndex).animate({marginLeft:"0px"});
					return false;
				});
				
				$(".next").not(".next-last").click(function() {
					if( $("#step"+currStep+"form").valid() == true){
						$("#steps li.active").removeClass("active").next().addClass("active");
						$("#step"+currStep).animate({marginLeft:"-"+$(document).width()+"px"});
						currStep++;
						$("#step"+currStep).animate({marginLeft:"0px"});
					}
					return false;
				});
				$(".next-last").click(function() {
					if( $("#step"+currStep+"form").valid() == true){
						$.post( "<?=$base?><?=$wizard_url?>", $( ".wiz-form" ).serialize(), function(data) {
							data = eval('('+data+')');
							if(data[0] == 'redirect'){
								window.location = data[1];
							}
						} );

						$("#steps li.active").removeClass("active").next().addClass("active");
						$("#step"+currStep).animate({marginLeft:"-"+$(document).width()+"px"});
						currStep++;
						$("#step"+currStep).animate({marginLeft:"0px"});
					}
				});
				$(".back").click(function() {
					$("#steps li.active").removeClass("active").prev().addClass("active");
					$("#step"+currStep).animate({marginLeft:$(document).width()+"px"});
					currStep--;
					$("#step"+currStep).animate({marginLeft:"0px"});
					return false;
				});
			});
		</script>-->
		<div class="container content">
		<!--<ul id="steps">
			<? foreach($wizard as $step):?>
				<li><a href="#"><?=$step['name']?></a></li>
			<? endforeach; ?>
		</ul>-->
		
			<? $i = 0; foreach($wizard as $step): ?>
				<form method="post" action="<?=(isset($wizard_url) ? $wizard_url : '');?>" id="step<?=$i+1;?>form" class="wiz-form">
					<table id="step<?=$i+1;?>">
						<? if(isset($step['fields'])): foreach($step['fields'] as $preference):?>
							<tr class="col-md-12 col-xl-12 col-l-12">
								<th class="col-md-3 col-xl-3 col-l-3"><?=$preference['Descript']?></th>
								<td class="col-md-3 col-xl-3 col-l-3"><input type="<?if($preference['Code'] == 'password'):?>password<?else:?>text<?endif;?>" name='preferences[<?=$preference[0]?>]' <?if($preference['typeOfPreference'] != 0 && isset($preference['Code'])):?>class="<?=$preference['Code']?>"<? endif;?> <?if($preference['SystemPreference'] == 1):?>required<?endif;?>/></td>
							</tr>
						<? endforeach; endif;?>
						<tr>
							<td><?if($i != 0):?><a href="#" class="back">&laquo; </a><?endif; ?></td>
							<td><a href="#" class="next<?if(end($wizard) == $step):?>-last<?endif;?>" onclick="$('.wiz-form').submit();"><?if(end($wizard) == $step):?>Finish<? else: ?>Volgende<?endif;?></a></td>
						</tr>
					</table>
				</form>
			<? $i++; endforeach; ?>
		</div>