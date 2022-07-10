<?

	//주문자 정보를 tmp에 저장
	$sql = "insert into ks_order_tmp (userid,oname,ozip1,ozip2,ozipcode,oaddr1,oaddr2,otel1,otel2,otel3,ohp1,ohp2,ohp3,oemail,pname,pzip1,pzip2,pzipcode,paddr1,paddr2,ptel1,ptel2,ptel3,php1,php2,php3,ment,paymode,account,result_price,ship_price,ship_mode,amt,saleTxt,sale_price,coupon_price,coupon,point,status,ip,reg_date) ";
	$sql .= "values ('$userid','$oname','$ozip1','$ozip2','$ozipcode','$oaddr1','$oaddr2','$otel1','$otel2','$otel3','$ohp1','$ohp2','$ohp3','$oemail','$pname','$pzip1','$pzip2','$pzipcode','$paddr1','$paddr2','$ptel1','$ptel2','$ptel3','$php1','$php2','$php3','$ment','$pay_mode','$ac_name','$result_price','$ship_price','$ship_mode','$amt','$saleTxt','$sale_price','$cChk','$couponTxt','$uPrice','접수','$user_ip','$reg_date')";
	$result = mysql_query($sql);


	//주문내역을 저장.
	$id_list = explode(',',$cart_idx);
	$tot = count($id_list);

	for($i=0; $i<$tot; $i++){
		$uid = $id_list[$i];

		$sql01 = "select * from ks_cart where uid='$uid'";
		$result01 = mysql_query($sql01);
		$row01 = mysql_fetch_array($result01);

		$pid = $row01['pid'];					
		$pdate = $row01['pdate'];				
		$pea = ${'ea'.$uid};					
		$price01 = ${'p1'.$uid};				
		$price02 = ${'p2'.$uid};				
		$price03 = ${'op'.$uid} * $pea;		

		
		$gdata01 = $row01['gdata01'];
		$gdata02 = $row01['gdata02'];
		$gdata03 = $row01['gdata03'];
		$gdata04 = $row01['gdata04'];
		$gdata05 = $row01['gdata05'];
		$gdata06 = $row01['gdata06'];
		$gdata07 = $row01['gdata07'];
		$gdata08 = $row01['gdata08'];
		$gdata09 = $row01['gdata09'];

		$sql03 = "insert into ks_order_list_tmp (userid,code,pid,pcade01,pcade02,ptitle,pdate,pea,price01,price02,price03,gdata01,gdata02,gdata03,gdata04,gdata05,gdata06,gdata07,gdata08,gdata09,mdata01,mdata02,mdata03,mdata04,mdata05,bdata01,bdata02,bdata03,bdata04,bdata05,bdata06,bdata07,cdata01,cdata02,cdata03,cdata04,cdata05,cdata06,cdata07,etc01,etc02,etc03,etc04) values ('$userid','$reg_date','$pid','$pcade01','$pcade02','$ptitle','$pdate','$pea','$price01','$price02','$price03','$gdata01','$gdata02','$gdata03','$gdata04','$gdata05','$gdata06','$gdata07','$gdata08','$gdata09','$mdata01','$mdata02','$mdata03','$mdata04','$mdata05','$bdata01','$bdata02','$bdata03','$bdata04','$bdata05','$bdata06','$bdata07','$cdata01','$cdata02','$cdata03','$cdata04','$cdata05','$cdata06','$cdata07','$etc01','$etc02','$etc03','$etc04')";
		$result03 = mysql_query($sql03);
	}
?>
