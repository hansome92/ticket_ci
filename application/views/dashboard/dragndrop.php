
<!--<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>gridster.js Test Suite</title>
  <!-- Load local jQuery, removing access to $ (use jQuery, not $). --
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

  <script src="<?=$base?><?=$base?>js/dashboard/dashboard/gridster.js" type="text/javascript" charset="utf-8"></script>

  <link rel="stylesheet" type="text/css" href="<?=$base?><?=$base?>js/dashboard/dashboard/gridster/dist/jquery.gridster.css">
  <link rel="stylesheet" type="text/css" href="<?=$base?><?=$base?>css/dashboard/gridster/style.css">


  <style type="text/css"> 
  [data-col="4"] { left:490px; }
  [data-col="3"] { left:330px; }
  [data-col="2"] { left:170px; }
  [data-col="1"] { left:10px; }
  [data-row="4"] { top:490px; }
  [data-row="3"] { top:330px; }
  [data-row="2"] { top:170px; }
  [data-row="1"] { top:10px; }
  [data-sizey="1"] { height:140px; }
  [data-sizey="2"] { height:300px; }
  [data-sizey="3"] { height:460px; }
  [data-sizey="4"] { height:620px; }
  [data-sizex="1"] { width:140px; }
  [data-sizex="2"] { width:300px; }
  [data-sizex="3"] { width:460px; }
  [data-sizex="4"] { width:620px; }
  </style>
</head>
<body>


    <div role="main">
        <section class="demo">
            <div class="gridster ready">
              <ul style="height: 480px; width: 960px; position: relative;">
                <? for($i=0;$i<3;$i++): ?>
                <? for ($j=0; $j < 4; $j++): ?>
                <? if($i == 1 && $j == 2): ?>
                    <li data-row="<?=($j+1)?>" data-col="<?=($i+1)?>" data-sizex="1" data-sizey="1" class="gs-w barcode" id="<?=($i.$j)?>">Barcode<span class="gs-resize-handle gs-resize-handle-both"></span></li>
                <? else: ?>
                    <li data-row="<?=($j+1)?>" data-col="<?=($i+1)?>" data-sizex="1" data-sizey="1" class="gs-w"><span class="gs-resize-handle gs-resize-handle-both"></span></li>
                <? endif; ?>
    <? endfor; ?>
<? endfor; ?>
</ul>
</div>
<a href="#" id="serialize">Serialize</a>
</section>
<script src="<?=$base?><?=$base?>js/dashboard/dashboard/gridster.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">
var gridster;

$(function(){

    gridster = $(".gridster > ul").gridster({
        widget_margins: [10, 10],
        widget_base_dimensions: [140, 140],
        min_cols: 3,
        max_cols: 3,
        min_rows: 4,
        max_rows: 4,

        resize: {
            enabled: false
        }
    }).data('gridster');
    $("#serialize").click( function(e){
        e.preventDefault();
        var s = gridster.serialize();
        console.log(s);
    });
    // var collection = [
    //     ['<li><div class="title">drag</div>Widget content</li>', 1, 2],
    //     ['<li><div class="title">drag</div>Widget content</li>', 5, 2],
    //     ['<li><div class="title">drag</div>Widget content</li>', 3, 2],
    //     ['<li><div class="title">drag</div>Widget content</li>', 2, 1],
    //     ['<li><div class="title">drag</div>Widget content</li>', 4, 1],
    //     ['<li><div class="title">drag</div>Widget content</li>', 1, 2],
    //     ['<li><div class="title">drag</div>Widget content</li>', 2, 1],
    //     ['<li><div class="title">drag</div>Widget content</li>', 3, 2],
    //     ['<li><div class="title">drag</div>Widget content</li>', 1, 1],
    //     ['<li><div class="title">drag</div>Widget content</li>', 2, 2],
    //     ['<li><div class="title">drag</div>Widget content</li>', 1, 3],
    // ];

    // $.each(collection, function(i, widget){
    //     gridster.add_widget.apply(gridster, widget)
    // });

});
</script>


<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-33489625-1']);
_gaq.push(['_trackPageview']);

(function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>

</body>
</html>
-->

<!--<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Draggable + Sortable</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <style>
    body {
        font-family: "Trebuchet MS", "Helvetica", "Arial",  "Verdana", "sans-serif";
        font-size: 62.5%;
        background: #28B78D;
    }
    
    ul { list-style-type: none; margin: 0; padding: 0; margin-bottom: 10px; }
    li { margin: 10px; padding: 5px; width: 138px; height:138px; float:left;}
    #sortable{
        margin: 0px auto;
        padding: 15px;
        border: 2px solid #000;
        display:block; 
        width: 510px; 
        height:680px;
        float:left;
    }
    #source{
        min-height: 500px;
        height:100%;
        width: 180px;
        display:block; 
        float:left;
        border: 2px solid #000;
        margin: 0 15px;

    }
    .draggable{
        border:none;
        height:140px;
        width:140px;
    }
</style>

  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
$(function() {
    $( "#sortable" ).sortable({
      connectToSortable: "#draggable",
      revert: true
  });
    $( ".draggable" ).draggable({
      connectToSortable: "#sortable",
      helper: "original",
      revert: "invalid"
  });
    $( ".draggable" ).droppable({
      connectToSortable: "#sortable",
      helper: "original",
      revert: "invalid"
  });

    $( "ul, li" ).disableSelection();
});
$(".delete").click(function(){
    var element = $(this).parent();
    alert($(this).parent().html());
    $("#source").append( $(this).parent() );
});
</script>
</head>
<body>
    <ul id="source">
        <? for ($i=1; $i < 12; $i++):?>
            <li class="draggable ui-state-highlight" style="background: url('../<?=$base?>images/dashboard/placeholder.png') #fff; background-size: 100%;"><span class="delete" style="cursor: pointer;">X</span></li>
        <? endfor; ?>
      
    </ul>

  <ul id="sortable">
    <? for ($i=0; $i < 1; $i++): ?>
    <li class="ui-state-default barcode"  id="<?=$i?>">Barcode item <?=$i?></li>
<? endfor; ?>

</ul>

</body>
</html>--

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>droppable demo</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <style>
  #draggable {
    width: 100px;
    height: 100px;
    background: #ccc;
  }
  #droppable {
    position: relative;
    float:left;
    #left: 250px;
    #top: 0;
    width: 150px;
    height: 150px;
    background: #999;
    color: #fff;
    padding: 10px;
    margin: 10px;
  }
  </style>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <style type="text/css">
    body {
        font-family: "Trebuchet MS", "Helvetica", "Arial",  "Verdana", "sans-serif";
        font-size: 62.5%;
        background: #28B78D;
    }
    
    ul { list-style-type: none; margin: 0; padding: 0; margin-bottom: 10px; }
    li { margin: 10px; padding: 5px; width: 138px; height:138px; float:left;}
    #gridwrapper{
        margin: 0px auto;
        padding: 15px;
        border: 2px solid #000;
        display:block; 
        width: 510px; 
        height:680px;
        float:left;
    }
    #source{
        min-height: 500px;
        height:100%;
        width: 180px;
        display:block; 
        float:left;
        border: 2px solid #000;
        margin: 0 15px;
    }
    .draggable, .droppable{
        border:none;
        height:140px;
        width:140px;
        background: #fff;
        margin: 10px;
        padding: 5px;
        float:left;
        display: block;
    }
  </style>
</head>
<body>
 

<div id="source">
    <? for ($i=1; $i < 12; $i++):?>
        <img class="draggable" src="../<?=$base?>images/dashboard/placeholder.png" />
    <? endfor; ?>
</div>
<div id="gridwrapper">
    <? for ($i=1; $i < 13; $i++):?>
        <div class="droppable"></div>
    <? endfor; ?>
</div>
<!--<div class="draggable">Drag me</div>--
 
<script>
    $( ".draggable" ).draggable();
    $( ".droppable" ).droppable({
        drop: function(e, ui) {
            console.log( $(ui.draggable).attr('src') );
            $(this).css('background', 'url("'+$(ui.draggable).attr('src') + '")');
            $(this).css('background-size', '100%');
            $(ui.draggable).remove();
        }
    });
</script>
 
</body>
</html>-->