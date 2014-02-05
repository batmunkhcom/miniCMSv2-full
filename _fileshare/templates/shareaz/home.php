
       <table width="99%" border="0" cellspacing="1" cellpadding="3">
         <tr>
           <td width="30%" bgcolor="#F5F5F5">&nbsp;</td>
           <td bgcolor="#F5F5F5"> <div id="image_loading" style="display:none;text-align:center; padding:5px;">
         Файлыг хуулж байна. Файл оруулах хугацаа нь файлын хэмжээ болон таны интернэтийн хурдаас шалтгаалах бөгөөд дууссаны дараа татажж авах хаяг гарч ирнэ..<br />
         <img src="images/loading.gif">        </div>
		<form name="form" action="" method="POST" enctype="multipart/form-data" id="uploadForm">
		  <table width="100%" align="center" cellpadding="0" cellspacing="0" class="tableForm">

		<thead>
			<tr>
				<th style="font-weight:normal;">Хуулах файлаа сонгоод ХУУЛЖ ЭХЭЛЭХ товчийг дарна уу.</th>
			</tr>
		</thead>
		<tbody>	
			<tr>
				<td align="center"><input id="fileToUpload" type="file" size="60" name="fileToUpload" class="input"></td>			</tr>
		</tbody>
			<tfoot>
				<tr>
					<td align="center"><button class="button" id="buttonUpload" onClick="return ajaxFileUpload();">Хуулж эхэлэх</button>	</td>
				</tr>
				<tr>
				  <td align="center">&nbsp;</td>
				  </tr>
			</tfoot>
	</table>
		</form> </td>
         </tr>
         <tr>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
         </tr>
       </table>
        <div id="uploadResult"></div>   
         <table width="99%" border="1" cellpadding="3" cellspacing="0" style="border-collapse:collapse; border:1px solid #DDDDDD;">
            <tr>
              <td bgcolor="#e2e2e2" >&nbsp;</td>
              <td width="35%" bgcolor="#e2e2e2"><strong>Бүртгэлгүй хэрэглэгчид</strong></td>
              <td width="35%" bgcolor="#e2e2e2"><strong>Бүртгэлтэй хэрэглэгчид</strong></td>
            </tr>
            <tr>
              <td >Татах хурд</td>
              <td align="center">32KB/секунд</td>
              <td align="center">Энгийн хэрэглэгч - 256KB/секунд<br />
                2 түвшинт хэрэглэгч - 384KB/секунд<br />
                3 түвшинт хэрэглэгч - 512KB/секунд<br />
                4 түвшинт хэрэглэгч - 1МB/секунд<br />
                5 түвшинт хэрэглэгч - 10МВ/секунд</td>
            </tr>
            <tr>
              <td >Татагдаагүй файл хадгалах хугацаа</td>
              <td align="center">7 хоног</td>
              <td align="center">Энгийн хэрэглэгч - 14 хоног<br />
2 түвшинт хэрэглэгч - 28  хоног<br />
3 түвшинт хэрэглэгч - 42  хоног<br />
4 түвшинт хэрэглэгч - 90  хоног<br />
5 түвшинт хэрэглэгч - 888 хоног</td>
            </tr>
            <tr>
              <td >Файл хуулах хэмжээ</td>
              <td align="center">100МВ</td>
              <td align="center">Энгийн хэрэглэгч - 200 МВ<br />
2 түвшинт хэрэглэгч - 300 МВ<br />
3 түвшинт хэрэглэгч - 400 МВ<br />
4 түвшинт хэрэглэгч - 500 МВ<br />
5 түвшинт хэрэглэгч - 800 МВ</td>
            </tr>
            <tr>
              <td bgcolor="#e2e2e2" ><strong>Сарын хураамж</strong></td>
              <td align="center" bgcolor="#e2e2e2"><strong>ҮНЭГҮЙ</strong></td>
              <td align="center" bgcolor="#e2e2e2"><strong>ҮНЭГҮЙ</strong></td>
            </tr>
          </table>      