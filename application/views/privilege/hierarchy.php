<?php
/**
 * @author ajith
 * @date 17 Feb, 2015
 */
?>
<style type="text/css">

    .hierarchy-table{
     

    }
    .hierarchy-table>.hierarchy{
        width:100%;
        margin: auto;
    }
    .hierarchy{

    }
    .hierarchy .hierarchy{
        float: left;
        position: relative;
    }
    .hierarchy p{
        text-align: center;
        font-size: 11px;
        line-height: 12px;
        margin: 0px;
    }
    .hierarchy img{
        width:30px;
        height: 30px;
        margin-left:  auto;
        margin-right:  auto;
        margin-top:  4px;
        margin-bottom:  4px;
        display: block;

    }
    .line, .line1, .line2{
        width: 1px;
        height: 1px;
        background-color: #367fa9;
        position: absolute;
        top:0px;
        left:50%;
    }

    .hierarchy-box{
        padding: 20px 0px;
        display: block;
    }
    .hierarchy-box>div{
        padding: 0px 5px;
        display: table;
        margin: auto;
        position: relative;
        width: 150px; 
        
    }
    .hierarchy-box>div>div{
        height: 88px;
        border: 1px solid #367fa9;
         border-radius: 5px;
    }
   
    .hierarchy-box .actions{
        display:none;
        text-align: center
    }
    .hierarchy-box .actions a{
        font-size: 10px;
        margin: 0px 3px;
    }
    .hierarchy-box>div:hover .actions{
        display:block;
    }
    .hierarchy .circle{
        border: 1px solid #367fa9;
        background: #367fa9;
        color: white;
        width: 20px;
        height: 20px;
        position: absolute;
        border-radius: 20px;
         bottom:0px;
        left:50%;
        margin-left: -10px;
        margin-bottom:-20px;
        z-index: 100;
        display: table;
        text-align: center;
        vertical-align: central;
        font-size: 16px;
        line-height: 13px;
        font-weight: bold;
    }
    .hierarchy.visible  {
        visibility: visible;
    }
    .hierarchy.not-visible {
        visibility: hidden;
    }
    


</style>
<section class="content-header">
    <h1>
        Managerial Hierarchy
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Managerial Hierarchy</li>
    </ol>
</section>

<section id="content" class="content" >
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div  class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title"></h3>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <div  class="row">
                        <div class="col-xs-12" style="overflow: auto;padding-bottom: 50px;">
                            <?php $hierarchy = hierarchy(0,$end_node_count); ?>
                            <div class="hierarchy-table" style="width:<?php echo $end_node_count*160; ?>px;">
                                <?php echo $hierarchy; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">

    $(document).ready(function () {
        draw_hierarchy();
        $(window).resize(draw_hierarchy);
    });
    function draw_hierarchy() {
        var lines = $('.line')
        draw_hierarchy_structure(lines);
    }

    function draw_hierarchy_structure(lines) {
        var parent_box, id, box_id;
        $(lines).each(function () {

            parent_box = $(this).parent('.hierarchy').parent('.hierarchy').children('.hierarchy-box');
            // console.log(parent_box.length);
            if (parent_box.length) {
                box_id = $(parent_box).attr('id');
                id = $(this).attr('id');
                connect(document.getElementById(id), document.getElementById(box_id), $(this).parent('.hierarchy'));
            }
        });
    }
    function getOffset(el) { // return element top, left, width, height
        var _x = 0;
        var _y = 0;
        var _w = el.offsetWidth | 0;
        var _h = $(el).height() | 0;
        while (el && !isNaN(el.offsetLeft) && !isNaN(el.offsetTop)) {
            _x += el.offsetLeft - el.scrollLeft;
            _y += el.offsetTop - el.scrollTop;
            el = el.offsetParent;
        }
        return {top: _y, left: _x, width: _w, height: _h};
    }

    function connect(div1, div2, parent) { // draw a line connecting elements
        var off1 = getOffset(div1);
        var off2 = getOffset(div2);

        var x1 = off1.left;
        var y1 = off1.top;
        var x2 = off2.left + (off2.width / 2);
        var y2 = off2.top + off2.height;

        var left1 = (x2 - x1 >= 0) ? 0 : x2 - x1;
        var left2 = (x2 - x1 >= 0) ? x2 - x1 : x2 - x1;

        if (Math.abs(left1) <= 2) {
            left1 = 0;
        }
        if (Math.abs(left2) <= 2) {
            left2 = 0;
        }

        $(parent).find('.line').css({
            'height': Math.abs(y2 - y1) / 2,
            'width': 1,
        });

        $(parent).find('.line1').css({
            'height': 1,
            'width': Math.abs(x2 - x1),
            'margin-left': left1 + 'px'
        });

        $(parent).find('.line2').css({
            'height': Math.abs(y2 - y1) / 2,
            'width': 1,
            'margin-left': left2 + 'px',
            'margin-top': (y2 - y1) / 2,
        });
        
    }
</script>
