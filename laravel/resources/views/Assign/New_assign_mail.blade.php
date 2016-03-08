<style type="text/css">
.mail_text{
  word-break:break-word;
  font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;
  color:#333;
  font-size:15px;
  font-weight:300;
  line-height:20px;
  padding-bottom:15px;
  text-align:left;
}
.left_col{
  width:20%;
}
.right_col{
  width:80%;
}
</style>
<table style="font-size:inherit;line-height:inherit;text-align:center;border-spacing:0;border-collapse:collapse;padding:0px;border:0px;font-family: Helvetica Neue,Arial,sans-serif;" align="center" border="0" cellpadding="0" cellspacing="0" width="685px">
    <tbody><tr style="width:685px;" class="ecxdevWidth">
          <td style="padding-right:36px;padding-left:40px;">
            <table style="font-size:inherit;line-height:inherit;padding:0px;border:0px;">
              <tbody><tr>
                <td style="padding-top:8px;text-align:right;" align="right"><img src="http://www.ojconsultinggroup.com/images/OJ_6.gif" ></td>
              </tr>
               <tr>
				   <td style="word-break:break-word;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;color:#333;font-size:15px;font-weight:300;line-height:20px;padding-bottom:15px;text-align:left;">
             เรียน คุณ {{ $name }},
				  </td>
			   </tr>
			   <tr>
				   <td style="word-break:break-word;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;color:#333;font-size:15px;font-weight:300;line-height:20px;padding-bottom:15px;text-align:left;">
             คุณได้รับมอบหมายให้ไปทำงานกับบริษัท OJ Consulting Group
              </td>
			   </tr>
			   <tr>
				   <td style="word-break:break-word;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;color:#333;font-size:15px;font-weight:300;line-height:20px;padding-bottom:15px;text-align:left;">
             <table class="mail_text">
               <tr><td colspan="2">รายละเอียดของงาน</td></tr>
               <tr>
                   <td class="left_col">ชื่องาน</td>
                   <td class="right_col">{{$event_name}}</td>
               </tr>
               <tr>
                   <td class="left_col">วันที่</td>
                   <td class="right_col">{{$event_date}}</td>
               </tr>
               <tr>
                   <td class="left_col">เวลานัดหมาย</td>
                   <td class="right_col">{{$staff_appointment_time}}</td>
               </tr>
               <tr>
                   <td class="left_col">ชื่อลูกค้า</td>
                   <td class="right_col">{{$customer_name}}</td>
               </tr>
               <tr>
                   <td class="left_col">สถานที่</td>
                   <td class="right_col">{{$venue_name}}</td>
               </tr>
               <tr>
                   <td class="left_col">ที่ตั้งสถานที่</td>
                   <td class="right_col">{{$venue_address}}</td>
               </tr>
             </table>
          </td>
			   </tr>
			   <tr>
				   <td style="word-break:break-word;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;color:#333;font-size:15px;font-weight:300;line-height:20px;padding-bottom:15px;text-align:left;">
              กรุณา
              <a href="{{ $root_url }}/response/{{ $userid }}/{{ $idcard }}/{{ $id }}/Confirm" style="color:rgb(0, 138, 205);text-decoration:none;" target="_blank">ตอบรับทำงานนี้</a> หรือ
              <a href="{{ $root_url }}/response/{{ $userid }}/{{ $idcard }}/{{ $id }}/Reject" style="color:rgb(255, 0, 0);text-decoration:none;" target="_blank">ปฎิเสธทำงานนี้</a>
           </td>
			   </tr>
			   <tr>
				   <td style="word-break:break-word;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;color:#333;font-size:15px;font-weight:300;line-height:20px;padding-bottom:34px;text-align:left;">
             หรือสามารถเข้าไปดูรายละเอียดเพิ่มเติมได้ที่ระบบของ OJ Consulting Group : <a href="http://www.ojconsultinggroup.com/4oj/" style="color:rgb(0, 138, 205);text-decoration:none;" target="_blank">http://www.ojconsultinggroup.com/4oj/</a></p>
           </td>
			   </tr>
			   <tr>
			   	   <td style="word-break:break-word;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;color:#333;font-size:15px;font-weight:300;line-height:20px;padding-bottom:29px;text-align:left;">
						OJ Consulting Group</td>
			   </tr>
            </tbody></table>
          </td>
        </tr>
	   <tr>
		 <td colspan="3" style="font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;width:685px;font-size:11px;line-height:14px;color:#888;text-align:center;background-repeat:no-repeat;background-position:center top;padding:19px 0 12px;" align="center" background="https://statici.icloud.com/emailimages/v4/common/footer_gradient_web.png">&nbsp;</td>
	   </tr>
	   <tr>
		 <td colspan="3" style="padding-top:3px;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;width:685px;font-size:11px;line-height:14px;color:#888;text-align:center;" align="center">&nbsp;</td>
	   </tr>
	   <tr style="height:50px;" height="50"><td style="font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;"></td></tr>
      </tbody>
</table>
