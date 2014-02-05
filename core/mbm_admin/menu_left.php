<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="logout"><a href="index.php">
      <?=$lang["admin"]["home"]?>
      </a> | <a href="logout.php">
        <?=$lang["admin"]["logout"]?>
      </a></div></td>
  </tr>
  <tr>
    <td><div id="menu_main" onclick="show_sub('menu2')"><img src="images/icon_menus.jpg" width="23" height="19" hspace="3" align="absmiddle" />
            <?
							echo $lang['admin_leftmenu']['menu'];
							?>
    </div>
        <div id="menu2" style="display:none;
					border-bottom:1px solid #000000;">
          <div id="submenu"><a href="index.php?module=menu&amp;cmd=menu_add">
            <?=$lang['admin_leftmenu']['menu_add']?>
          </a></div>
          <div id="submenu"><a href="index.php?module=menu&cmd=menu_list">
            <?=$lang['admin_leftmenu']['menu_list']?>
          </a></div>
          <div id="submenu"><a href="index.php?module=menu&amp;cmd=content_add">
            <?= $lang['admin_leftmenu']['content_add']?>
          </a></div>
          <div id="submenu"><a href="index.php?module=menu&amp;cmd=content_list">
            <?= $lang['admin_leftmenu']['content_list']?>
          </a></div>
          <div id="submenu"><a href="index.php?module=menu&amp;cmd=comments">
            <?= $lang["admin_leftmenu"]["content_comments"]?>
          </a></div>
          <div id="submenu"><a href="index.php?module=comments&amp;cmd=list">
            <?= $lang["admin_leftmenu"]["content_comments"]?> - 2
          </a></div>
          <div id="submenu"><a href="index.php?module=menu&amp;cmd=menu_permission_add">
            <?= $lang['admin_leftmenu']['user_permission_add']?>
          </a></div>
          <div id="submenu"><a href="index.php?module=menu&amp;cmd=menu_permissions_list">
            <?= $lang['admin_leftmenu']['user_permission_list']?>
          </a></div>
          <div id="submenu"><a href="index.php?module=shoutbox&amp;cmd=list">
            <?= $lang['shoutbox']['title']?>
          </a></div>
          <div id="submenu"><a href="index.php?module=menu&amp;cmd=menu_users">menu users</a></div>
          <div id="submenu"><a href="index.php?module=fileshare&cmd=myfiles">Fileshare</a></div>
        </div>
      <div id="menu_main" onclick="show_sub('menu3')"><img src="images/icon_banners.jpg" width="23" height="19" hspace="3" align="absmiddle" />
          <?=$lang['admin_leftmenu']['banners']?>
      </div>
      <div id="menu3" style="display:none;
                    border-bottom:1px solid #000000;">
          <div id="submenu"><a href="index.php?module=banner&amp;cmd=banner_add">
            <?=$lang['admin_leftmenu']['banner_add']?>
          </a></div>
        <div id="submenu"><a href="index.php?module=banner&cmd=banner_list">
          <?=$lang['admin_leftmenu']['banner_list']?>
        </a></div>
      </div>
      <div id="menu_main" onclick="show_sub('menu4')"><img src="images/icon_users.jpg" width="23" height="19" hspace="3" align="absmiddle" />
          <?=$lang['admin_leftmenu']['users']?>
        </div>
      <div id="menu4" style="display:none;
	border-bottom:1px solid #000000;">
          <div id="submenu"><a href="index.php?module=users&cmd=user_add">
            <?=$lang['admin_leftmenu']['user_add']?>
          </a></div>
        <div id="submenu"><a href="index.php?module=users&cmd=user_list&st=0">
          <?=$lang['admin_leftmenu']['users_inactive']?>
        </a></div>
        <div id="submenu"><a href="index.php?module=users&cmd=user_list&st=1">
          <?=$lang['admin_leftmenu']['users_active']?>
        </a></div>
        <div id="submenu"><a href="index.php?module=users&cmd=reg_info&st=1">
          <?=$lang['admin_leftmenu']['users_registrations']?>
        </a></div>
        <div id="submenu"><a href="#"  onclick="confirmSubmit('<?=$lang['confirm']['activate_all_users']?>','index.php?module=users&cmd=st_1')">
          <?=$lang['admin_leftmenu']['activate_all_users']?>
        </a></div>
      </div>
      <div id="menu_main" onclick="show_sub('menu5')"><img src="images/icon_config.gif" width="23" height="19" hspace="3" align="absmiddle" />
          <?=$lang["admin_leftmenu"]["auto_module"]?>
      </div>
      <div id="menu5" style="display:none;
	border-bottom:1px solid #000000;">
          <div id="submenu"><a href="index.php?module=auto&cmd=car_add">
            <?=$lang["admin_leftmenu"]["car_add"]?>
          </a></div>
        <div id="submenu"><a href="index.php?module=auto&cmd=firms">
          <?=$lang['admin_leftmenu']['car_firms']?>
        </a></div>
        <div id="submenu"><a href="index.php?module=auto&cmd=marks">
          <?=$lang['admin_leftmenu']['car_marks']?>
        </a></div>
        <div id="submenu"><a href="index.php?module=auto&cmd=cars">
          <?=$lang['admin_leftmenu']['car_list']?>
        </a></div>
      </div>
      <div id="menu_main" onclick="show_sub('menu6')"><img src="images/icon_polls.jpg" width="23" height="19" hspace="3" align="absmiddle" />
          <?=$lang["admin_leftmenu"]["poll_module"]?>
      </div>
      <div id="menu6" style="display:none;
	border-bottom:1px solid #000000;">
          <div id="submenu"><a href="index.php?module=poll&cmd=add_poll">
            <?= $lang['admin_leftmenu']['poll_add']?>
          </a></div>
        <div id="submenu"><a href="index.php?module=poll&cmd=list_poll">
          <?= $lang['admin_leftmenu']['poll_list']?>
        </a></div>
      </div>
      <div id="menu_main" onclick="show_sub('menu7')"><img src="images/icon_settings.jpg" width="23" height="19" hspace="3" align="absmiddle" />
          <?=$lang["admin_leftmenu"]["settings"]?>
      </div>
      <div id="menu7" style="display:none;
	border-bottom:1px solid #000000;">
          <div id="submenu"><a href="index.php?module=settings&cmd=settings">
            <?=$lang["admin_leftmenu"]["settings_main"]?>
          </a></div>
        <div id="submenu"><a href="index.php?module=settings&cmd=admin_history">
          <?=$lang["admin_leftmenu"]["admin_history"]?>
        </a></div>
      </div>
      <div id="menu_main" style="display:none;" onclick="show_sub('menu8')"><img src="images/icon_users.gif" width="23" height="19" hspace="3" align="absmiddle" />Зурхай</div>
      <div id="menu8" style="display:none;
	border-bottom:1px solid #000000;">
          <div id="submenu"><a href="index.php?module=zurkhai&cmd=add">
            <?= $lang['zurkhai']['add']?>
          </a></div>
        <div id="submenu"><a href="index.php?module=zurkhai&cmd=list">
          <?= $lang['zurkhai']['list']?>
        </a></div>
      </div>
      <div id="menu_main" onclick="show_sub('menu9')"><img src="images/icon_web.jpg" width="23" height="19" hspace="3" align="absmiddle" />
            <?=$lang["admin_leftmenu"]["web_module"]?>
      </div>
      <div id="menu9" style="display:none;
	border-bottom:1px solid #000000;">
          <div id="submenu"><a href="index.php?module=web&cmd=cat_add">
            <?=$lang["admin_leftmenu"]["web_category_add"]?>
          </a></div>
        <div id="submenu"><a href="index.php?module=web&cmd=cat_list">
          <?=$lang["admin_leftmenu"]["web_category_list"]?>
        </a></div>
        <div id="submenu"><a href="index.php?module=web&cmd=link_add">
          <?=$lang["admin_leftmenu"]["web_link_add"]?>
        </a></div>
        <div id="submenu"><a href="index.php?module=web&cmd=link_list">
          <?=$lang["admin_leftmenu"]["web_link_list"]?>
        </a></div>
      </div>
      <div id="menu_main" onclick="show_sub('menu10')"><img src="images/icon_forums.jpg" width="23" height="19" hspace="3" align="absmiddle" />
          <?=$lang["admin_leftmenu"]["forum_module"]?>
      </div>
      <div id="menu10" style="display:none;
	border-bottom:1px solid #000000;">
          <div id="submenu"><a href="index.php?module=forum&cmd=forum_add">
            <?=$lang["admin_leftmenu"]["forum_add"]?>
          </a></div>
        <div id="submenu"><a href="index.php?module=forum&cmd=forums">
          <?=$lang["admin_leftmenu"]["forum_list"]?>
        </a></div>
        <div id="submenu"><a href="index.php?module=forum&cmd=moderators">
          <?=$lang["admin_leftmenu"]["forum_moderators"]?>
        </a></div>
      </div>
      <div id="menu_main" onclick="show_sub('menu11')"><img src="images/icon_shopping.jpg" width="23" height="19" hspace="3" align="absmiddle" /><?=$lang["admin_leftmenu"]["Shop"]?></div>
      <div id="menu11" style="display:none;
	border-bottom:1px solid #000000;">
          <div id="submenu"><a href="index.php?module=shopping&amp;cmd=cat_add">
            <?=$lang["shopping"]["add_category"]?>
          </a></div>
        <div id="submenu"><a href="index.php?module=shopping&cmd=cat_list">
          <?=$lang["shopping"]["categories"]?>
        </a></div>
        <div id="submenu"><a href="index.php?module=shopping&amp;cmd=product_add">product add</a></div>
        <div id="submenu"><a href="index.php?module=shopping&amp;cmd=product_list">products</a></div>
        <div id="submenu"><a href="index.php?module=shopping&amp;cmd=type_add">type add</a></div>
        <div id="submenu"><a href="index.php?module=shopping&amp;cmd=type_list">types</a></div>
      </div>
      <div id="menu_main" onclick="show_sub('menu12')"><img src="images/icon_blogs.jpg" width="23" height="19" hspace="3" align="absmiddle" />
          <?=$lang["admin_leftmenu"]["blog_module"]?>
      </div>
      <div id="menu12" style="display:none;
	border-bottom:1px solid #000000;">
          <div id="submenu"><a href="#">blog </a></div>
        <div id="submenu"><a href="#">blog content view</a></div>
      </div>
      <div id="menu_main" onclick="show_sub('menu13')"><img src="images/icon_dic.jpg" width="23" height="19" hspace="3" align="absmiddle" />
          <?=$lang["admin_leftmenu"]["dic_module"]?>
      </div>
      <div id="menu13" style="display:none;
	border-bottom:1px solid #000000;">
          <div id="submenu"><a href="index.php?module=dic&cmd=lang_list">
            <?=$lang["admin_leftmenu"]["dic_lang_list"]?>
          </a></div>
        <div id="submenu"><a href="index.php?module=dic&cmd=word_add">
          <?=$lang["admin_leftmenu"]["dic_word_add"]?>
        </a></div>
        <div id="submenu"><a href="index.php?module=dic&cmd=encyc_add">
          <?=$lang["admin_leftmenu"]["dic_encyclopedia_add"]?>
        </a></div>
      </div>
      <div id="menu_main" onclick="show_sub('menu14')"><img src="images/icon_faqs.jpg" width="23" height="19" hspace="3" align="absmiddle" />
          <?=$lang["admin_leftmenu"]["faqs_module"]?>
      </div>
      <div id="menu14" style="display:none;
	border-bottom:1px solid #000000;">
          <div id="submenu"><a href="index.php?module=faqs&cmd=new">
            <?=$lang["admin_leftmenu"]["faqs_new"]?>
          </a></div>
        <div id="submenu"><a href="index.php?module=faqs&cmd=list">
          <?=$lang["admin_leftmenu"]["faqs_list_all"]?>
        </a></div>
      </div>
      <div id="menu_main" onclick="show_sub('menu15')"><img src="images/icon_pg.jpg" width="23" height="19" hspace="3" align="absmiddle" />
          <?=$lang["admin_leftmenu"]["photogallery_module"]?>
      </div>
      <div id="menu15" style="display:none;
	border-bottom:1px solid #000000;">
          <div id="submenu"><a href="index.php?module=photogallery&cmd=cats">
            <?=$lang["admin_leftmenu"]["photogallery_categories"]?>
          </a></div>
        <div id="submenu"><a href="index.php?module=photogallery&cmd=cat_add">
          <?=$lang["admin_leftmenu"]["photogallery_cat_add"]?>
        </a></div>
        <div id="submenu"><a href="index.php?module=photogallery&cmd=photo_files">
          <?=$lang["admin_leftmenu"]["photogallery_files"]?>
        </a></div>
      </div>
      <div id="menu_main" onclick="show_sub('menu16')"><img src="images/icon_pg.jpg" width="23" height="19" hspace="3" align="absmiddle" />
          Newsletter
      </div>
      <div id="menu16" style="display:none;
	border-bottom:1px solid #000000;">
          <div id="submenu"><a href="index.php?module=newsletter&cmd=add">
            Add newsletter
          </a></div>
          <div id="submenu"><a href="index.php?module=newsletter&cmd=list">
            List newsletter
          </a></div>
          <div id="submenu"><a href="index.php?module=newsletter&cmd=emails">
            Emails
          </a></div>
          <div id="submenu"><a href="index.php?module=newsletter&cmd=email_del">
            Delete email
          </a></div>
      </div>
      <div id="menu_main" onclick="show_sub('menu17')"><img src="images/icon_pg.jpg" width="23" height="19" hspace="3" align="absmiddle" />
          <?=$lang["zar"]["zar_module"]?>
      </div>
      <div id="menu17" style="display:none;	border-bottom:1px solid #000000;">
          <div id="submenu"><a href="index.php?module=zar&cmd=cat_add">
            <?=$lang["zar"]["add_category"]?>
          </a></div>
          <div id="submenu"><a href="index.php?module=zar&cmd=cat_list">
            <?=$lang["zar"]["categories"]?>
          </a></div>
          <div id="submenu"><a href="index.php?module=zar&cmd=zar_admins">
            <?=$lang["zar"]["zar_operators"]?>
          </a></div>
          <div id="submenu"><a href="index.php?module=zar&cmd=zar_type_add">
            <?=$lang["zar"]["zar_types"]?>
          </a></div>
      </div>
      <div id="menu_main" onclick="show_sub('menu18')"><img src="images/icon_pg.jpg" width="23" height="19" hspace="3" align="absmiddle" />
          <?=$lang["admin_leftmenu"]["company"]?>
      </div>
      <div id="menu18" style="display:none;	border-bottom:1px solid #000000;">
          <div id="submenu"><a href="index.php?module=companies&cmd=categories">
            <?=$lang["admin_leftmenu"]["categories"]?>
          </a></div>
          <div id="submenu"><a href="index.php?module=companies&cmd=company_services">
            <?=$lang["admin_leftmenu"]["company_services"]?>
          </a></div>
          <div id="submenu"><a href="index.php?module=companies&cmd=company_add">
            <?=$lang["admin_leftmenu"]["company_add"]?>
          </a></div>
          <div id="submenu"><a href="index.php?module=companies&cmd=companies">
             <?=$lang["admin_leftmenu"]["company"]?>
          </a></div>
      </div>
      <div id="menu_main" style="display:none;" onclick="show_sub('menu88')"><img src="images/icon_users.gif" width="23" height="19" hspace="3" align="absmiddle" />Дуу хөгжим</div>
      <div id="menu88" style="display:none; border-bottom:1px solid #000000;">
          <div id="submenu"><a href="index.php?module=music&cmd=types"><strong>Хөгжмийн төрөл</strong></a></div>
        <div id="submenu"><a href="index.php?module=music&cmd=type_add">Хөгжмийн төрөл нэмэх</a></div>
        <div id="submenu"><a href="index.php?module=music&cmd=singers"><strong>Дуучид</strong></a></div>
        <div id="submenu"><a href="index.php?module=music&cmd=singer_add">Дуучин нэмэх</a></div>
        <div id="submenu"><a href="index.php?module=music&cmd=songs"><strong>Дуунууд</strong></a></div>
        <div id="submenu"><a href="index.php?module=music&cmd=song_add">Дуу нэмэх</a></div>
        <div id="submenu"><a href="index.php?module=music&amp;cmd=songs&amp;start=0&amp;action=no_clip" >Клипгүй дуунууд</a></div>
        <div id="submenu"><a href="index.php?module=music&amp;cmd=no_3gp&amp;start=0" >3GP гүй дуунууд</a></div>
      </div>
      <div id="menu_main" style="display:none;" onclick="show_sub('menu89')"><img src="images/icon_users.gif" width="23" height="19" hspace="3" align="absmiddle" />Хэрэглэгчийн видео</div>
      <div id="menu89" style="display:none; border-bottom:1px solid #000000;">
          <div id="submenu"><a href="index.php?module=video&cmd=video_add"><strong>Видео нэмэх</strong></a></div>
        <div id="submenu"><a href="index.php?module=video&cmd=video_edit"><strong>Видео засах</strong></a></div>
        <div id="submenu"><a href="index.php?module=video&cmd=video_list"><strong>Видеоны жагсаалт</strong></a></div>
      </div>
      <div id="menu_main" onclick="show_sub('menu99')"><img src="images/icon_stats.jpg" width="23" height="19" hspace="3" align="absmiddle" />
          <?=$lang["admin_leftmenu"]["stats_module"]?>
      </div>
      <div id="menu99" style="display:none;
	border-bottom:1px solid #000000;">
          <div id="submenu"><a href="index.php?module=stats&cmd=bydomain">Зочин илгээлт</a></div>
      </div>
      <div id="menu_main" onclick="show_sub('menu98')"><img src="images/icon_dl.jpg" width="23" height="19" hspace="3" align="absmiddle" />
          <?=$lang["admin_leftmenu"]["download_module"]?>
      </div>
      <div id="menu98" style="display:none;
	border-bottom:1px solid #000000;">
          <div id="submenu"><a href="index.php?module=phazeddl&cmd=link_add">Хаяг нэмэх</a></div>
      </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<script language="javascript">
function tempSession(){
	setTimeout("mbmLoadXML('GET','<?=DOMAIN.DIR?>xml.php',mbmSession)",180000);
	tempSession();
}
tempSession();
</script>