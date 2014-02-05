<div id="talbar2_2"
    style="
           position:relative;
           display:block;
           "
>
    <div id="talbar2_col_1">
        <?
        echo mbmUNEGUICOMcontents(array(
                            'menu_id'=>0,
                            'limit'=>20,
                            'order_by'=>'date_added',
                            'asc'=>'desc',
                            'type'=>'normal',
                            'st'=>1
                            ));
        ?>
    </div>
    <!--talbar2_col2_2 starts//-->
  <div id="talbar2_col_2">
        <div class="border_g">
            <div class="talbar_title_g">Мэдээ, мэдээлэл
            </div>
            <div style="padding:5px; display:block; height:100px">
            <?=mbmContentNews($htmls_normal,mbmShowByLang(array('mn'=>367,'en'=>8888)),1,1,'date_added','DESC',0,1)?>
            </div>
        </div>
    <div style="display:block; position:relative; height:600px;">
            <div id="col2_sub1" 
                    style="
                        position:absolute;
                        display:block;
                        left:0px;
                        top:0px;
                        width:236px;">
                <div class="border_b">
                    <div class="talbar_title_b">Дурын 10 мэдээ
                    </div>
                    <div style="padding:5px;">
                        <?=mbmContentNews(array('','','- ','<br />'),mbmShowByLang(array('mn'=>0,'en'=>8888)),0,10,'RAND()','')?>
                    </div>
                </div>
                <div class="border_b">
                    <div class="talbar_title_b">Эрэлттэй 10 мэдээ                                  </div>
                    <div style="padding:5px;">
                        <?=mbmContentNews(array('','','- ','<br />'),mbmShowByLang(array('mn'=>0,'en'=>8888)),0,10,'hits','DESC')?>
                    </div>
                </div>
                <div class="border_b">
                    <div class="talbar_title_b">Хамтрагчид
                    </div>
                    <div style="padding:5px; text-align:center; height:130px;">
                        <marquee truespeed="truespeed" direction="up" scrollamount="1" scrolldelay="30"  onmouseover="this.stop()" onmouseout="this.start()" >
                        <?=mbmShowBanner('partners')?>
                        </marquee>
                    </div>
                </div>
            </div>
            <div id="col2_sub2" 
                    style="
                        position:absolute;
                        display:block;
                        width:120px;
                        left:240px;
                        top:0px;
                        width:200px;">
               <?=mbmShowBanner('right_2')?>
            </div>
    </div>
    <!--talbar2_col2_2 ends//-->
    <!--talbar2_col2_3 starts//-->
     <div id="talbar2_col2_3"
                style="
                    background-image:url(templates/unegui2/images/talbar1_3_title_bg.jpg);
                    background-repeat:repeat-x;
                    margin-bottom:4px;
                    ">
            <div 
                        style="
                            background-image:url(templates/unegui2/images/talbar3_sum.png);
                            background-repeat:no-repeat;
                            background-position:8px  6px;
                            padding-left:32px;
                            padding-top:8px;
                            padding-bottom:8px;
                            font-weight:bold;
                            border:1px solid #d3e2c1;
                            margin-top:10px;
                        ">
                        Мэдээний сэтгэгдлүүд</div>
            <div style="padding:5px; height:333px; overflow-y:auto; display:block;
	border-left:1px solid #d3e2c1;
	border-right:1px solid #d3e2c1;
	border-bottom:1px solid #d3e2c1;">
                <?=mbmShowContentComment(array('content_id'=>0,
                                'limit'=>50,
                                'order_by'=>'date_added',
                                'asc'=>'DESC',
                                'show_title'=>1
                                )
                        )?>
            </div>
    </div>
    <!--talbar2_col2_3 ends//-->
    <!--talbar2_col2_4 starts//-->
    <div style="display:block; margin-bottom:4px;">
    <img src="templates/unegui2/images/banner_sq.jpg" alt="a" width="360" height="284" /></div>
    <!--talbar2_col2_4 ends//-->
  </div>
</div>
<div id="talbar2_3"></div>
<div id="talbar2_4"></div>
<div id="talbar2_5"></div>